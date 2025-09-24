<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManajemenAbsensiController extends Controller
{
    public function index(Request $request)
    {
        // Query data absensi dengan relasi ke tabel user
        $query = Absensi::with('user');

        // Filter berdasarkan nama karyawan (pencarian)
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        } elseif ($request->date) {
            $query->whereDate('created_at', $request->date);
        } else {
            $query->whereDate('check_in', Carbon::today());
        }

        // Ambil absensi yang sudah difilter dan urutkan berdasarkan check_in
        $absensi = $query->orderBy('check_in', 'desc')->paginate(10);

        return view('manajemen.absensi.index', compact('absensi'));
    }
}
