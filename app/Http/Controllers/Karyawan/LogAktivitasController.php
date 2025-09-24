<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::where('user_id', auth()->id());

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),  // Mulai dari awal hari
                Carbon::parse($request->end_date)->endOfDay()       // Sampai akhir hari
            ]);
        } elseif ($request->date) {
            // Jika hanya memilih satu tanggal
            $query->whereDate('created_at', $request->date);
        } else {
            // Default tampilkan log hari ini jika tidak ada filter
            $query->whereDate('created_at', Carbon::today());
        }

        // Ambil log dan urutkan dari yang terbaru
        $logs = $query->orderBy('created_at', 'desc')->get();

        return view('karyawan.log.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link_bukti' => 'nullable|url',
        ]);

        $log = new LogAktivitas();
        $log->user_id = auth()->id();
        $log->aktivitas = $request->judul;
        $log->deskripsi = $request->deskripsi;
        $log->link = $request->link_bukti; // Opsional
        $log->save();

        return back()->with('success', 'Aktivitas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'aktivitas' => 'required|string|max:255', // Ubah dari 'judul' ke 'aktivitas'
            'deskripsi' => 'required|string',
            'link' => 'nullable|url' // Ubah dari 'link_bukti' ke 'link'
        ]);

        try {
            // Find the log entry
            $log = LogAktivitas::findOrFail($id);
            $log->aktivitas = $validatedData['aktivitas'];
            $log->deskripsi = $validatedData['deskripsi'];
            $log->link = $validatedData['link'] ?? null; // Opsional
            $log->save();

            // Redirect back with success message
            return back()->with('success', 'Aktivitas berhasil diperbarui');
        } catch (\Exception $e) {
            // Handle any errors
            return back()->with('error', 'Gagal memperbarui aktivitas: ' . $e->getMessage());
        }
    }
}
