<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ServisController;
use App\Http\Controllers\SukuCadangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LaporanController;


// Halaman Login (Tanpa Layout)
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Grouping Berdasarkan Hak Akses
Route::middleware(['auth'])->group(function () {

    // Rute khusus Admin
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
        Route::get('/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan.index');
        Route::post('/pelanggan', [PelangganController::class, 'store'])->name('admin.pelanggan.store');
        Route::put('/pelanggan/{id}', [PelangganController::class, 'update']);
        Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy']);

        Route::get('/jadwal', [ServisController::class, 'index']);
        Route::post('/jadwal', [ServisController::class, 'store']);
        Route::put('/jadwal/{id}', [ServisController::class, 'update']);
        Route::delete('/jadwal/{id}', [ServisController::class, 'destroy']);

// Pastikan di dalam group admin
        Route::get('/suku-cadang', [SukuCadangController::class, 'index'])->name('admin.suku_cadang.index');
        Route::post('/suku-cadang', [SukuCadangController::class, 'store'])->name('admin.suku_cadang.store');
        Route::put('/suku-cadang/{id}', [SukuCadangController::class, 'update'])->name('admin.suku_cadang.update');
        Route::delete('/suku-cadang/{id}', [SukuCadangController::class, 'destroy'])->name('admin.suku_cadang.destroy');

        Route::get('/teknisi-list', [UserController::class, 'index']);
        Route::post('/teknisi-list', [UserController::class, 'store']);
        Route::put('/teknisi-list/{id}', [UserController::class, 'update']);
        Route::delete('/teknisi-list/{id}', [UserController::class, 'destroy']);

        Route::get('/admin/jadwal/cetak/{id}', [ServisController::class, 'cetakNota'])->name('admin.jadwal.cetak');

        Route::get('/admin/notifikasi', [AdminNotificationController::class, 'index'])->name('admin.notifikasi.index');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
            
    });

    // Rute khusus Teknisi
    Route::prefix('teknisi')->group(function () {
        Route::get('/dashboard', [TeknisiController::class, 'dashboard'])->name('teknisi.dashboard');
        Route::get('/jadwal', [TeknisiController::class, 'index'])->name('teknisi.jadwal.index');
        Route::put('/jadwal/{id}', [TeknisiController::class, 'updateDetail'])->name('teknisi.jadwal.update');
        Route::get('/teknisi/riwayat', [TeknisiController::class, 'riwayat'])->name('teknisi.riwayat.index');
        Route::get('/teknisi/stok', [TeknisiController::class, 'stok'])->name('teknisi.stok.index');
        });
});