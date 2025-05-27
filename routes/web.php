<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\QRCodeController;

// Admin Controllers
use App\Http\Controllers\Admin\KambingController as AdminKambingController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;

// User Controllers
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\KambingController as UserKambingController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\User\RiwayatController;
use App\Http\Controllers\User\PesananController as UserPesananController;


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
// ADMIN AREA (auth required)
// ====================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminKambingController::class, 'index'])->name('home');

    // Kambing
    Route::prefix('kambing')->name('kambing.')->group(function () {
        Route::get('/', [AdminKambingController::class, 'index'])->name('index');
        Route::get('/tambah', [AdminKambingController::class, 'create'])->name('tambah');
        Route::post('/', [AdminKambingController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AdminKambingController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [AdminKambingController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [AdminKambingController::class, 'destroy'])->name('destroy');
    });

    // Pengguna
    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/', [PenggunaController::class, 'index'])->name('index');
        Route::get('/tambah', [PenggunaController::class, 'create'])->name('tambah');
        Route::post('/', [PenggunaController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PenggunaController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PenggunaController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [PenggunaController::class, 'destroy'])->name('destroy');
    });

    // Pesanan
    Route::prefix('pesanan')->name('pesanan.')->group(function () {
        Route::get('/', [AdminPesananController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminPesananController::class, 'show'])->name('show');
        Route::put('/{id}/status', [AdminPesananController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}', [AdminPesananController::class, 'destroy'])->name('destroy');
    });
});

// ====================
// USER AREA (auth required)
// ====================
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');

    // Kambing
    Route::get('/kambing', [UserKambingController::class, 'index'])->name('kambing');
    Route::get('/kambing/{id}/beli', [UserKambingController::class, 'beli'])->name('kambing.beli');

    // Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

    // Checkout
    // Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    // Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout');
    // Route::post('/user/checkout', [CheckoutController::class, 'checkout'])->name('user.user.checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
  

    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout'); // ✅ benar
  

    // Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');

    // Pesanan
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');

    Route::get('/pesanan', [UserPesananController::class, 'index'])->name('pesanan');
    Route::get('/beli/{id}', [UserPesananController::class, 'beli'])->name('beli');
    Route::post('/beli/{id}', [UserPesananController::class, 'beli'])->name('beli.post');

    // QR Code
    Route::get('/qrcode/{id}', [QRCodeController::class, 'generate'])->name('qrcode');
    Route::get('/qrcode/generate/{id}', [QRCodeController::class, 'generate'])->name('qrcode.generate');
    Route::get('/qrcode/show/{id}', [QRCodeController::class, 'show'])->name('qrcode.show');
});

// ====================
// PUBLIC ROUTES (Tanpa login)
// ====================
Route::get('/kambing', [UserKambingController::class, 'index'])->name('kambing.public');
Route::get('/beli/{id}', [UserPesananController::class, 'beli'])->name('beli.public');
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.public.tambah');
Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.public.hapus');
