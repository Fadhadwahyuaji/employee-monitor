<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        // Data untuk semua role
        $totalUsers = $user->roles->contains('name', 'admin') ? User::count() : null;
        $aktifUsers = $user->roles->contains('name', 'admin')
            ? Absensi::whereDate('check_in', today())->distinct('user_id')->count()
            : null;

        $absensiStatus = $user->roles->contains('name', 'karyawan')
            ? Absensi::where('user_id', $user->id)
            ->whereDate('check_in', today())
            ->value('status') ?? 'Belum Absen'
            : null;

        $absensiHistory = $user->roles->contains('name', 'karyawan')
            ? Absensi::where('user_id', $user->id)
            ->latest('check_in')
            ->take(5)
            ->get()
            : [];

        $absenMasuk = Absensi::where('user_id', $user->id)
            ->where('status', 'masuk')
            ->whereDate('check_in', '>=', Carbon::now()->subDays(30)) // 30 hari terakhir
            ->count();

        $absenIzin = Absensi::where('user_id', $user->id)
            ->where('status', 'izin')
            ->whereDate('check_in', '>=', Carbon::now()->subDays(30)) // 30 hari terakhir
            ->count();

        $absenSakit = Absensi::where('user_id', $user->id)
            ->where('status', 'sakit')
            ->whereDate('check_in', '>=', Carbon::now()->subDays(30)) // 30 hari terakhir
            ->count();

        $totalMasuk = $user->roles->contains('name', 'manajemen')
            ? Absensi::where('status', 'masuk')->count()
            : null;

        $totalIzin = $user->roles->contains('name', 'manajemen')
            ? Absensi::where('status', 'izin')->count()
            : null;

        $totalSakit = $user->roles->contains('name', 'manajemen')
            ? Absensi::where('status', 'sakit')->count()
            : null;

        return view('home', compact(
            'totalUsers',
            'aktifUsers',
            'absensiStatus',
            'absensiHistory',
            'absenMasuk',
            'absenIzin',
            'absenSakit',
            'totalMasuk',
            'totalIzin',
            'totalSakit'
        ));
    }
}
