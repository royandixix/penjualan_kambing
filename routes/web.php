<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\KambingController;
use App\Http\Controllers\Admin\PenggunaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| File ini berisi semua rute yang digunakan dalam aplikasi.
|--------------------------------------------------------------------------
*/

// ====================
// Redirect root URL ke halaman login
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
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ====================
// Halaman berdasarkan role (dengan middleware auth)
// ====================
Route::middleware(['auth'])->group(function () {

    // Admin - view admin.kambing.index
    Route::get('/admin/kambing', function () {
        return view('admin.kambing.index');
    })->name('admin.kambing.index');

    // User/Pembeli - view user.index
    Route::get('/user', function () {
        return view('user.index');
    })->name('pembeli.index');
});

// ====================
// Dashboard (sementara tanpa pembatasan role)
// ====================
Route::get('/dashboard', [KambingController::class, 'index'])->name('dashboard');

// ====================
// ADMIN AREA (Prefix dan Grouping)
// ====================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard admin
    Route::get('/', [KambingController::class, 'index'])->name('home');

    // CRUD Kambing
    Route::get('/kambing', [KambingController::class, 'index'])->name('kambing.index');
    Route::get('/kambing/tambah', [KambingController::class, 'create'])->name('kambing.tambah');
    Route::post('/kambing', [KambingController::class, 'store'])->name('kambing.store');
    Route::get('/kambing/edit/{id}', [KambingController::class, 'edit'])->name('kambing.edit');
    Route::put('/kambing/update/{id}', [KambingController::class, 'update'])->name('kambing.update');
    Route::delete('/kambing/destroy/{id}', [KambingController::class, 'destroy'])->name('kambing.destroy');

    // CRUD Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/tambah', [PenggunaController::class, 'create'])->name('pengguna.tambah');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/edit/{id}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/pengguna/update/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/destroy/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
});
