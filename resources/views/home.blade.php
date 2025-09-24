@extends('layouts.theme')

@section('content')
    <div class="container mx-auto py-6 px-4">
        <div class="grid grid-cols-1 gap-6">
            <h1 class="text-4xl font-bold mb-4 text-gray-700">Dashboard</h1>

            <!-- Employee Dashboard -->
            @if (Auth::user()->roles->contains('name', 'karyawan'))
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-700 mb-4">Absensi & Log Aktivitas</h3>

                    <div class="space-y-4">
                        <!-- Status Kehadiran -->
                        <div class="border-b pb-4">
                            <p class="text-gray-600">
                                <span class="font-semibold">Status Hari Ini:</span>
                                <span class="text-indigo-600 font-bold">{{ $absensiStatus }}</span>
                            </p>
                        </div>

                        <!-- Total Kehadiran -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Masuk 30 Hari Terakhir</span>
                                <span class="text-indigo-600 font-bold">{{ $absenMasuk }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Izin 30 Hari Terakhir</span>
                                <span class="text-yellow-600 font-bold">{{ $absenIzin }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Sakit 30 Hari Terakhir</span>
                                <span class="text-red-600 font-bold">{{ $absenSakit }}</span>
                            </div>
                        </div>

                        <!-- Riwayat Kehadiran -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-2">Riwayat Kehadiran</h4>
                            <ul class="space-y-2">
                                @forelse ($absensiHistory as $history)
                                    <li class="flex justify-between text-gray-600">
                                        <span>
                                            {{ \Carbon\Carbon::parse($history->check_in)->translatedFormat('l, j F Y') }}</span>
                                        <span class="font-bold text-indigo-500">{{ $history->status }}</span>
                                    </li>
                                @empty
                                    <li class="text-gray-500">Belum ada riwayat kehadiran.</li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if ($absensiStatus === 'Belum Absen')
                                <a href="{{ route('karyawan.absensi.index') }}"
                                    class="block bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700">
                                    Absen Sekarang
                                </a>
                            @elseif ($absensiStatus === 'masuk')
                                <a href="{{ route('karyawan.log.index') }}"
                                    class="block bg-green-600 text-white text-center py-2 rounded-lg hover:bg-green-700">
                                    Buat Log Aktivitas Baru
                                </a>
                                <a href="{{ route('karyawan.absensi.index') }}"
                                    class="block bg-red-600 text-white text-center py-2 rounded-lg hover:bg-red-700">
                                    Absen Keluar
                                </a>
                            @else
                                <p class="text-gray-500">Anda sudah menyelesaikan absensi hari ini.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Management Dashboard -->
            @if (Auth::user()->roles->contains('name', 'manajemen'))
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-700">Monitor Absensi</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Kehadiran</span>
                            <span class="text-indigo-600 font-bold">{{ $totalMasuk }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Izin</span>
                            <span class="text-yellow-600 font-bold">{{ $totalIzin }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Sakit</span>
                            <span class="text-red-600 font-bold">{{ $totalSakit }}</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('manajemen.absensi.index') }}"
                            class="block bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700">
                            Lihat Laporan
                        </a>
                    </div>
                </div>
            @endif

            <!-- Admin Dashboard -->
            @if (Auth::user()->roles->contains('name', 'admin'))
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-700">Admin Dashboard</h3>
                    <ul class="space-y-2">
                        <li>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total User</span>
                                <span class="text-indigo-600 font-bold">{{ $totalUsers }}</span>
                            </div>
                        </li>
                        <li>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">User Aktif Hari Ini</span>
                                <span class="text-green-600 font-bold">{{ $aktifUsers }}</span>
                            </div>
                        </li>
                    </ul>
                    <div class="mt-4 space-y-2">
                        <a href="{{ route('admin.user.index') }}"
                            class="block bg-indigo-600 text-white text-center py-2 rounded-lg hover:bg-indigo-700">
                            Kelola User
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
