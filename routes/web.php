<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\KambingController;


Route::get('/', function(){
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Tambahan (jika belum dibuat), arahkan dashboard ke view tertentu
Route::get('/dashboard', function () {
    return view('dashboard'); // sesuaikan dengan view dashboard kamu
})->middleware('auth')->name('dashboard');



// admin
Route::get('/admin', function (){
    return view('admin.dashboard');
});


Route::get('/admin/kambing', [KambingController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/kambing', [KambingController::class, 'index'])->name('admin.dashboard');





