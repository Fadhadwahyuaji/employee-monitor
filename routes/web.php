<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\Karyawan\LogAktivitasController;
use App\Http\Controllers\Manajemen\ManajemenAbsensiController;
use App\Http\Controllers\Manajemen\ManajemenLogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


// Grup route untuk autentikasi
Route::middleware(['auth'])->group(function () {

    // Dashboard dengan role-based access
    Route::middleware('verified')->group(function () {
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

        // Route khusus role admin
        Route::middleware('role:admin')->prefix('admin')->group(function () {
            Route::get('user/index', [UserManagementController::class, 'index'])->name('admin.user.index');
            Route::post('user/buat', [UserManagementController::class, 'store'])->name('admin.user.store');
            Route::put('user/edit/{id}', [UserManagementController::class, 'update'])->name('admin.user.update');
            Route::delete('user/hapus/{id}', [UserManagementController::class, 'destroy'])->name('admin.user.destroy');
        });

        // Route khusus role karyawan
        Route::middleware('role:karyawan')->prefix('karyawan')->group(function () {
            Route::get('absensi', [AbsensiController::class, 'index'])->name('karyawan.absensi.index');
            Route::post('absenIn', [AbsensiController::class, 'absenIn'])->name('karyawan.absensi.in');
            Route::post('absenOut', [AbsensiController::class, 'absenOut'])->name('karyawan.absensi.out');
            Route::get('absensi/{id}', [AbsensiController::class, 'show'])->name('karyawan.absensi.show');

            Route::get('karyawan/log-aktivitas', [LogAktivitasController::class, 'index'])->name('karyawan.log.index');
            Route::post('karyawan/log-aktivitas/store', [LogAktivitasController::class, 'store'])->name('karyawan.log.store');
            Route::put('/log/{id}', [LogAktivitasController::class, 'update'])->name('karyawan.log.update');
        });

        // Route khusus role manajemen
        Route::middleware('role:manajemen')->prefix('manajemen')->group(function () {
            Route::get('manajemen/kelola-absensi', [ManajemenAbsensiController::class, 'index'])->name('manajemen.absensi.index');

            Route::get('log/index', [ManajemenLogController::class, 'index'])->name('manajemen.log.index');
            Route::get('log/detail/{id}', [ManajemenLogController::class, 'detail'])->name('manajemen.log.detail');
        });
    });

    // Route untuk profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';
