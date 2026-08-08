<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MovieManageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\BrowseMovieController;
use App\Http\Controllers\User\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RatingController;


// ============================
// AUTH (login/logout)
// ============================

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit')->middleware('guest');

Route::get('/verify-otp', [RegisterController::class, 'showOtpForm'])->name('otp.verify.form')->middleware('guest');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('otp.verify')->middleware('guest');
Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->name('otp.resend')->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.attempt')
    ->middleware(['guest', 'throttle:5,1']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ============================
// BERANDA & DETAIL FILM (publik, semua role + guest bisa akses)
// ============================
Route::get('/', [BrowseMovieController::class, 'index']);
Route::get('/user/browse', [BrowseMovieController::class, 'index'])->name('user.browse');
Route::get('/movie/{movie}', [BrowseMovieController::class, 'show'])->name('movie.detail');

// ============================
// FITUR USER BIASA (wajib login sebagai role "user")
// ============================
Route::middleware(['auth', 'user.only'])->prefix('user')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('user.orders');
    // routes/web.php — tambahin di dalam group user.only
});
Route::middleware(['auth', 'user.only'])->prefix('user')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('user.orders');
    Route::post('/movie/{movie}/checkout', [OrderController::class, 'store'])->name('movie.checkout');
    Route::post('/movie/{movie}/rate', [RatingController::class, 'store'])->name('movie.rate');
});

// ============================
// FITUR ADMIN (wajib login sebagai role "admin")
// ============================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/movies', [MovieManageController::class, 'index'])->name('admin.movies');
    Route::get('/movies/create', [MovieManageController::class, 'create'])->name('admin.movies.create');
    Route::post('/movies', [MovieManageController::class, 'store'])->name('admin.movies.store');
    Route::get('/movies/{movie}/edit', [MovieManageController::class, 'edit'])->name('admin.movies.edit');
    Route::put('/movies/{movie}', [MovieManageController::class, 'update'])->name('admin.movies.update');
    Route::delete('/movies/{movie}', [MovieManageController::class, 'destroy'])->name('admin.movies.destroy');
});
