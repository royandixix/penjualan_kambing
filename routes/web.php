<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

// Admin Controllers
use App\Http\Controllers\Admin\KambingController as AdminKambingController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PelangganController as AdminPelangganController;
use App\Http\Controllers\Admin\PenjualanController as AdminPenjualanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotifikasiController;

// User Controllers
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\KambingController as UserKambingController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\RiwayatController;
use App\Http\Controllers\User\PesananController as UserPesananController;
use App\Http\Controllers\User\QRCodeController;


/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// ====================
// HALAMAN AWAL
// ====================
Route::get('/', function () {
    $user = Auth::user();
    if ($user) {
        return redirect($user->role === 'Admin' ? '/admin' : '/user');
    }
    return redirect()->route('login');
});

// ====================
// AUTH
// ====================
Route::get('/show-qr/{user}', [AuthController::class, 'showLink'])->name('qrcode.showLink');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login/qr', [AuthController::class, 'loginWithQr'])->name('login.qr');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ====================
// ADMIN AREA
// ====================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ======= NOTIFIKASI ADMIN =======
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::get('/notifikasi/read/{id}', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::get('/notifikasi/read-all', [NotifikasiController::class, 'markAllRead'])->name('notifikasi.readAll');
    Route::delete('/notifikasi/delete/{id}', [NotifikasiController::class, 'delete'])->name('notifikasi.delete');
    Route::delete('/notifikasi/delete-all', [NotifikasiController::class, 'deleteAll'])->name('notifikasi.deleteAll');

    // Kambing
    Route::resource('kambing', AdminKambingController::class)->except(['show']);
    Route::get('kambing/export-pdf', [AdminKambingController::class, 'exportPdf'])->name('kambing.exportPdf');

    // Pengguna
    Route::resource('pengguna', PenggunaController::class)->except(['show']);

    // Pelanggan
    Route::resource('pelanggan', AdminPelangganController::class)->except(['show']);
    Route::get('pelanggan/export-pdf', [AdminPelangganController::class, 'exportPdf'])->name('pelanggan.exportPdf');

    // Penjualan
    Route::resource('penjualan', AdminPenjualanController::class)->except(['show']);
    Route::get('penjualan/export-pdf', [AdminPenjualanController::class, 'exportPdf'])->name('penjualan.exportPdf');

    // Pesanan
    Route::resource('pesanan', AdminPesananController::class);
    Route::put('pesanan/{id}/status', [AdminPesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    // Pembayaran
    Route::resource('pembayaran', PembayaranController::class)->except(['edit', 'update', 'destroy']);
    Route::get('pembayaran/cetak-pdf', [PembayaranController::class, 'cetakPdf'])->name('pembayaran.cetak_pdf');

    // ====================
    // LAPORAN
    // ====================
    Route::prefix('laporan')->name('laporan.')->group(function () {

        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/cetak', [LaporanController::class, 'cetak'])->name('cetak');

        // Kambing
        Route::get('/kambing', [LaporanController::class, 'laporanKambing'])->name('kambing');
        Route::get('/kambing/cetak', [LaporanController::class, 'cetakKambing'])->name('kambing.cetak');
        Route::get('/kambing/excel', [LaporanController::class, 'exportKambingExcel'])->name('kambing.excel');

        // Pelanggan
        Route::get('/pelanggan', [LaporanController::class, 'laporanPelanggan'])->name('pelanggan');
        Route::get('/pelanggan/cetak', [LaporanController::class, 'cetakPelanggan'])->name('pelanggan.cetak');
        Route::get('/pelanggan/excel', [LaporanController::class, 'exportPelangganExcel'])->name('pelanggan.excel');

        // Pembayaran
        Route::get('/pembayaran_kambing', [LaporanController::class, 'laporanPembayaranKambing'])->name('pembayaran_kambing');
        Route::get('/pembayaran_kambing/cetak', [LaporanController::class, 'cetakPembayaranKambing'])->name('pembayaran_kambing.cetak');

        // Pemesanan
        Route::get('/pemesanan', [LaporanController::class, 'laporanPemesanan'])->name('pemesanan');
        Route::get('/pemesanan/cetak', [LaporanController::class, 'cetakPemesanan'])->name('pemesanan.cetak');
        Route::get('/pemesanan/excel', [LaporanController::class, 'exportPemesananExcel'])->name('pemesanan.excel');

        // Penjualan
        Route::get('/penjualan', [LaporanController::class, 'laporanPenjualan'])->name('penjualan');
        Route::get('/penjualan/cetak', [LaporanController::class, 'cetakPenjualan'])->name('penjualan.cetak');
        Route::get('/penjualan/excel', [LaporanController::class, 'exportPenjualanExcel'])->name('penjualan.excel');
    });
});


// ====================
// USER AREA
// ====================
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {

    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/kambing', [UserKambingController::class, 'index'])->name('kambing');
    Route::get('/kambing/{id}/beli', [UserKambingController::class, 'beli'])->name('kambing.beli');

    // Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout');

    // Pesanan & Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/pesanan', [UserPesananController::class, 'index'])->name('pesanan');
    Route::get('/beli/{id}', [UserPesananController::class, 'beli'])->name('beli');
    Route::post('/beli/{id}', [UserPesananController::class, 'beli'])->name('beli.post');

    // QR Code
    Route::get('/qrcode/{id}', [QRCodeController::class, 'generate'])->name('qrcode');
    Route::get('/qrcode/generate/{id}', [QRCodeController::class, 'generate'])->name('qrcode.generate');
    Route::get('/qrcode/show/{id}', [QRCodeController::class, 'show'])->name('qrcode.show');


    // ================================
    // 🔔 NOTIFIKASI USER (Tanpa middleware)
    // ================================
    Route::get('/notifikasi', function () {
        $notifs = Auth::user()->notifications()->orderBy('created_at', 'desc')->get();
        return view('user.notifikasi.index', compact('notifs'));
    })->name('notifikasi.index');

    Route::get('/notifikasi/read/{id}', function ($id) {
        $notif = Auth::user()->notifications()->where('id', $id)->first();
        if ($notif) $notif->markAsRead();
        return back();
    })->name('notifikasi.read');

    Route::get('/notifikasi/read-all', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi sudah ditandai dibaca.');
    })->name('notifikasi.readAll');

});

// ====================
// FIX : ROUTE ERROR DIHAPUS
// ====================
// ❌ Route bermasalah:
// Route::get('/user/notifikasi', [NotifikasiController::class, 'index'])->name('user.notifikasi');

