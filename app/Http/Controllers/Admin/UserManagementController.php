<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    // Menampilkan daftar user
    public function index(Request $request)
    {
        $search = $request->input('search'); // Ambil parameter pencarian dari request

        $users = User::with('roles')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%'); // Sesuaikan kolom yang ingin dicari
            })
            ->get();

        $roles = Role::all();

        return view('admin.index', compact('users', 'roles'));
    }


    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|array', // Harus berupa array karena multiple role
            'role.*' => 'string|exists:roles,name', // Validasi bahwa role harus ada dalam tabel roles
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Mengambil ID role berdasarkan nama yang dipilih
        $roleIds = Role::whereIn('name', $validated['role'])->pluck('id');

        // Menyimpan ke tabel pivot `role_user`
        $user->roles()->sync($roleIds);

        return redirect()->route('admin.user.index')->with('success', 'User created successfully!');
    }




    // Menyimpan perubahan user
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed', // Password opsional
            'role' => 'nullable|array', // Role opsional
            'role.*' => 'nullable|string|exists:roles,name', // Validasi setiap role
        ]);

        // Temukan user
        $user = User::findOrFail($id);
        $user->name =  $validated['name'];
        $user->email =  $validated['email'];
        $user->password =  $validated['password'] ? Hash::make($validated['password']) : $user->password;
        $user->save();

        // Update roles jika ada
        if (!empty($validated['role'])) {
            $roles = Role::whereIn('name', $validated['role'])->pluck('id');
            $user->roles()->sync($roles);
        } else {
            // Jika tidak ada role dipilih, kosongkan
            $user->roles()->sync([]);
        }

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui!');
    }



    // Menghapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully!');
    }
}
