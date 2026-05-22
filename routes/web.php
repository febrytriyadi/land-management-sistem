<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TanahController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

// Public: Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('tanah', TanahController::class);
    Route::resource('penyewa', PenyewaController::class)->except(['show', 'destroy']);
    Route::resource('kontrak', KontrakController::class)->except(['edit', 'update', 'destroy']);

    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::put('/pembayaran/{pembayaran}/bayar', [PembayaranController::class, 'bayar'])->name('pembayaran.bayar');
    Route::put('/pembayaran/{pembayaran}', [PembayaranController::class, 'update'])->name('pembayaran.update');
    Route::get('/pembayaran/{pembayaran}/invoice', [PembayaranController::class, 'invoice'])->name('pembayaran.invoice');
    Route::post('/pembayaran/{pembayaran}/notifikasi', [PembayaranController::class, 'kirimNotifikasi'])->name('pembayaran.notifikasi');
    Route::post('/pembayaran/notifikasi-semua', [PembayaranController::class, 'kirimSemuaNotifikasi'])->name('pembayaran.notifikasi-semua');

    // Pegawai management — admin only
    Route::middleware('admin')->group(function () {
        Route::resource('pegawai', PegawaiController::class);
    });
});
