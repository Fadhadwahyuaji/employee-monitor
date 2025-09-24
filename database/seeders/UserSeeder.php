<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Menambahkan role terlebih dahulu
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $karyawanRole = Role::firstOrCreate(['name' => 'karyawan']);
        $manajemenRole = Role::firstOrCreate(['name' => 'manajemen']);

        // Membuat user dan mengaitkannya dengan role
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->roles()->attach($adminRole);

        $karyawan = User::create([
            'name' => 'Karyawan User',
            'email' => 'karyawan@example.com',
            'password' => Hash::make('password'),
        ]);
        $karyawan->roles()->attach($karyawanRole);

        $manajemen = User::create([
            'name' => 'Manajemen User',
            'email' => 'manajemen@example.com',
            'password' => Hash::make('password'),
        ]);
        $manajemen->roles()->attach($manajemenRole);
    }
}
