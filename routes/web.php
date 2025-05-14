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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ====================
// Redirect root ke login
// ====================
Route::get('/', fn() => redirect()->route('login'));

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

    // Kambing
    Route::get('/kambing', [UserKambingController::class, 'index'])->name('user.kambing');
    Route::get('/kambing/{id}/beli', [UserKambingController::class, 'beli'])->name('user.kambing.beli');

    // Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('user.keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('user.keranjang.tambah');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('user.keranjang.hapus');

    // Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('user.riwayat');

    // Checkout
    Route::get('/checkout', [KeranjangController::class, 'checkout'])->name('user.checkout');
});

// ====================
// PUBLIC ROUTES (Tanpa login)
// ====================
Route::get('/kambing', [UserKambingController::class, 'index'])->name('kambing.public');

// Tambah ke keranjang publik (opsional, jika pengguna tidak login bisa disimpan ke session)
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.public.tambah');
