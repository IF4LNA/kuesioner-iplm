<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PustakawanController;

// Rute login dan logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute umum (tanpa autentikasi)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/bantuan', [HomeController::class, 'bantuan'])->name('bantuan');

// Rute dengan autentikasi dan peran
Route::middleware('auth')->group(function () {
    // Dashboard admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    // Dashboard pustakawan
    Route::middleware('role:pustakawan')->group(function () {
        Route::get('/pustakawan/dashboard', [PustakawanController::class, 'index'])->name('pustakawan.dashboard');
    });
});

// route side-bar
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/manage-users', [AdminController::class, 'manageUsers'])->name('manage.users');
    // Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/uplm/{id}', [AdminController::class, 'showUplm'])->name('uplm.show');
    Route::get('/user/create', [AdminController::class, 'createUser'])->name('user.create');
    Route::get('/recap', [AdminController::class, 'recap'])->name('recap');
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// route halaman pustakawan
Route::middleware(['auth'])->group(function () {
    Route::get('/form/data', [PustakawanController::class, 'kuesioner'])->name('form.data');
});

Route::post('/isikuesioner', [PustakawanController::class, 'kirimData'])->name('isikuesioner');



