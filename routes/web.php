<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Admin Controllers
use App\Http\Controllers\Admin\KambingController as AdminKambingController;
use App\Http\Controllers\Admin\PenggunaController;

// User Controllers
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\KambingController as UserKambingController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\User\RiwayatController;
use App\Http\Controllers\User\KambingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ====================
// Redirect root ke login
// ====================
Route::get('/', fn () => redirect()->route('login'));

// ====================
// Login & Register
// ====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ====================
// ADMIN AREA
// ====================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminKambingController::class, 'index'])->name('home');

    // Kambing
    Route::get('/kambing', [AdminKambingController::class, 'index'])->name('kambing.index');
    Route::get('/kambing/tambah', [AdminKambingController::class, 'create'])->name('kambing.tambah');
    Route::post('/kambing', [AdminKambingController::class, 'store'])->name('kambing.store');
    Route::get('/kambing/edit/{id}', [AdminKambingController::class, 'edit'])->name('kambing.edit');
    Route::put('/kambing/update/{id}', [AdminKambingController::class, 'update'])->name('kambing.update');
    Route::delete('/kambing/destroy/{id}', [AdminKambingController::class, 'destroy'])->name('kambing.destroy');

    // Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/tambah', [PenggunaController::class, 'create'])->name('pengguna.tambah');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/edit/{id}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/pengguna/update/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/destroy/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
});

// ====================
// USER (PEMBELI) AREA
// ====================
Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/kambing', [UserKambingController::class, 'index'])->name('user.kambing');
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('user.keranjang');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('user.riwayat');

    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('user.keranjang.tambah');
    Route::get('/kambing/{id}/beli', [KambingController::class, 'beli'])->name('user.beli');
});

// ====================
// Public route untuk melihat kambing
// ====================
Route::get('/kambing', [App\Http\Controllers\User\KambingController::class, 'index'])->name('user.kambing');
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('user.keranjang.tambah');
