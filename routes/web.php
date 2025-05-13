<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\KambingController;
use App\Http\Controllers\Admin\PenggunaController;

// ====================
// Arahkan root URL ke halaman login
// ====================
Route::get('/', function () {
    return redirect()->route('login');
});

// ====================
// Login & Register
// ====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ====================
// Dashboard (sementara, bebas akses)
// ====================
Route::get('/dashboard', [KambingController::class, 'index'])->name('dashboard');

// ====================
// ADMIN AREA (tanpa middleware)
// ====================
Route::prefix('admin')->name('admin.')->group(function () {

    // Halaman utama admin
    Route::get('/', [KambingController::class, 'index'])->name('home');

    // CRUD Kambing
    Route::get('/kambing', [KambingController::class, 'index'])->name('kambing.index');
    Route::get('/kambing/tambah', [KambingController::class, 'create'])->name('kambing.tambah');
    Route::post('/kambing', [KambingController::class, 'store'])->name('kambing.store');
    Route::get('/kambing/edit/{id}', [KambingController::class, 'edit'])->name('kambing.edit');
    Route::put('/kambing/update/{id}', [KambingController::class, 'update'])->name('kambing.update');
    Route::delete('/kambing/hapus/{id}', [KambingController::class, 'destroy'])->name('kambing.hapus');
    Route::delete('/kambing/hapus/{id}', [KambingController::class, 'destroy'])->name('kambing.destroy');

    // CRUD Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/tambah', [PenggunaController::class, 'create'])->name('pengguna.tambah');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/edit/{id}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/pengguna/update/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/hapus/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.hapus');
});
