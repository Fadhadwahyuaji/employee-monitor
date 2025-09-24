<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManajemenLogController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input pencarian dari request
        $search = $request->get('search');

        // Ambil daftar user dengan role karyawan
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'karyawan');
        })
            ->when($search, function ($query) use ($search) {
                // Filter berdasarkan nama atau posisi (sesuaikan dengan field di database)
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();


        return view('manajemen.log.index', compact('users'));
    }

    public function detail(Request $request, $userId)
    {
        // Validasi user yang dipilih
        $user = User::findOrFail($userId);

        // Query log aktivitas
        $query = LogAktivitas::where('user_id', $userId);

        // Filter berdasarkan rentang tanggal
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
        $logs = $query->orderBy('created_at', 'asc')->get();

        // Kirim data ke view
        return view('manajemen.log.detail', [
            'user' => $user,
            'logs' => $logs,
            'selectedDate' => $request->date ?? Carbon::today()->format('Y-m-d'),
            'startDate' => $request->start_date ?? '',
            'endDate' => $request->end_date ?? ''
        ]);
    }



    public function exportLog(Request $request, $userId)
    {
        // Validasi user yang dipilih
        $user = User::findOrFail($userId);

        // Query log aktivitas
        $query = LogAktivitas::where('user_id', $userId);

        // Filter berdasarkan rentang tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        // Ambil log
        $logs = $query->orderBy('created_at', 'desc')->get();

        // Contoh ekspor ke CSV (bisa disesuaikan dengan kebutuhan)
        $filename = 'log_aktivitas_' . $user->name . '_' . now()->format('YmdHis') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Tanggal', 'Aktivitas', 'Deskripsi', 'Link Bukti']);

        foreach ($logs as $log) {
            fputcsv($handle, [
                $log->created_at->format('Y-m-d H:i:s'),
                $log->aktivitas,
                $log->deskripsi,
                $log->link
            ]);
        }

        fclose($handle);

        return response()->stream(function () use ($handle) {
            // Stream sudah ditangani di atas
        }, 200, $headers);
    }
}
