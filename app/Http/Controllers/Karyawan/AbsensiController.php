<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $cekAbsensi = Absensi::where('user_id', auth()->id())->whereNull('check_out')->first();

        // Inisialisasi query dasar
        $query = Absensi::where('user_id', auth()->id());

        // Filter berdasarkan tanggal
        if ($request->start_date && $request->end_date) {
            // Jika ada rentang tanggal
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),  // Mulai dari awal hari
                Carbon::parse($request->end_date)->endOfDay()       // Sampai akhir hari
            ]);
        } elseif ($request->date) {
            // Jika hanya memilih satu tanggal
            $query->whereDate('created_at', Carbon::parse($request->date));
        } else {
            // Default tampilkan log hari ini jika tidak ada filter
            $query->whereDate('created_at', Carbon::today());
        }

        // Menangani pencarian berdasarkan kata kunci
        if ($request->search) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        // Ambil hasil absensi berdasarkan filter yang diterapkan
        $absensi = $query->orderByDesc('created_at')->paginate(10);

        return view('karyawan.absensi.index', compact('cekAbsensi', 'absensi'));
    }



    public function absenIn(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'status' => 'required|in:masuk,sakit,izin',
            'photo' => 'required_if:status,sakit,izin|file|mimes:jpg,jpeg,png,pdf,doc,docx,heic|max:2048', // Validasi foto hanya untuk sakit/izin
        ]);

        // Membuat data absensi baru
        $absensi = new Absensi();
        $absensi->user_id = auth()->id();
        $absensi->check_in = now();  // Menyimpan waktu check-in
        $absensi->status = $request->status;

        // Upload foto hanya jika status sakit atau izin
        if ($request->hasFile('photo')) {
            $absensi->photo_path = $request->file('photo')->store('photos');
        }

        // Jika status sakit atau izin, tambahkan check-out otomatis
        if ($request->status == 'sakit' || $request->status == 'izin') {
            $absensi->check_out = now();
        }

        $absensi->save();

        // Membuat log aktivitas hanya jika status adalah 'masuk'
        if ($request->status == 'sakit') {
            $activityLog = new LogAktivitas();
            $activityLog->user_id = auth()->id();
            $activityLog->aktivitas = "Sakit";
            $activityLog->deskripsi = "Sedang Sakit";
            $activityLog->save();
        } elseif ($request->status == 'izin') {
            $activityLog = new LogAktivitas();
            $activityLog->user_id = auth()->id();
            $activityLog->aktivitas = "Izin";
            $activityLog->deskripsi = "Sedang Izin";
            $activityLog->save();
        } else {
            $activityLog = new LogAktivitas();
            $activityLog->user_id = auth()->id();
            $activityLog->aktivitas = "Absen Masuk";
            $activityLog->deskripsi = "Mulai hari kerja";
            $activityLog->save();
        }

        return redirect()->route('karyawan.absensi.index');
    }

    public function absenOut()
    {
        $absensi = Absensi::where('user_id', auth()->id())
            ->whereNull('check_out')
            ->first();

        if ($absensi) {
            $absensi->check_out = now();
            // $absensi->status = 'checked_out';
            $absensi->save();

            // Menambahkan log aktivitas untuk absen keluar
            $activityLog = new LogAktivitas();
            $activityLog->user_id = auth()->id();
            $activityLog->aktivitas = "Absen Keluar";
            $activityLog->deskripsi = "Selesai hari kerja";
            $activityLog->save();
        }

        return redirect()->route('karyawan.absensi.index');
    }


    public function show($id)
    {
        // Menampilkan detail absensi
    }
}
