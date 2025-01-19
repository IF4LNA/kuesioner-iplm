<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PustakawanController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\UplmController;
use App\Http\Controllers\PertanyaanController;

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

    //route uplm 1-7
    Route::get('/uplm/{id}', [UplmController::class, 'showUplm'])->name('uplm.show');

    //filter
    Route::get('/uplm/{id}', [UplmController::class, 'filterUplm'])->name('uplm');
    Route::get('/uplm/{id}/filterByYear', [UplmController::class, 'filterByYear'])->name('uplm.filterByYear');

    //buat akun
    Route::get('/user/create', [AdminController::class, 'createUser'])->name('user.create');

    // route buat akun
    Route::get('/admin/create-account', [AdminController::class, 'createAccountForm'])->name('admin.create-account');
    Route::post('/admin/create-account', [AdminController::class, 'storeAccount'])->name('admin.store-account');
    // web.php (routes)
    
    Route::get('/getSubjenis/{jenis}', [AdminController::class, 'getSubjenis']);

    //route rekap
    Route::get('/recap', [AdminController::class, 'recap'])->name('recap');
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');

    //route aktivitas admin
    Route::get('activity-logs', [AdminController::class, 'showActivityLogs'])->name('admin.activity-logs');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //route edit pertanyaan
    Route::get('/questions/{id}/edit', [PertanyaanController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{id}', [PertanyaanController::class, 'update'])->name('questions.update');

    //route membuat dan menghapus pertanyaan
    Route::get('/questions/create', [PertanyaanController::class, 'create'])->name('questions.create');
    Route::post('/questions', [PertanyaanController::class, 'store'])->name('questions.store');
    Route::delete('/questions/{id}', [PertanyaanController::class, 'destroy'])->name('questions.destroy');
});

// route halaman pustakawan
Route::middleware(['auth'])->group(function () {
    Route::get('/form/data', [PustakawanController::class, 'showForm'])->name('form.data');

    // Route untuk menyimpan data perpustakaan
    Route::post('/pustakawan/store', [PustakawanController::class, 'store'])->name('pustakawan.store');

    // Route untuk kehalaman isi kuesioner
    Route::get('/pustakawan/iskuesioner', [PustakawanController::class, 'IsiKuesioner'])->name('pustakawan.isikuesioner');
});

// Menampilkan form kuesioner berdasarkan tahun
Route::middleware(['auth', 'role:pustakawan'])->group(function () {
    // Menampilkan halaman kuesioner
    Route::get('/kuesioner', [PustakawanController::class, 'isikuesioner'])->name('pustakawan.isikuesioner');

    // Menampilkan form berdasarkan tahun yang dipilih
    Route::get('/kuesioner/form', [PustakawanController::class, 'showForm'])->name('kuesioner.form');

    //route lokasi alamat dropdownlist
    Route::get('/kecamatan/{id_kota}', [LokasiController::class, 'getKecamatan']);
    Route::get('/kelurahan/{id_kecamatan}', [LokasiController::class, 'getKelurahan']);

    // Menyimpan jawaban kuesioner
    Route::post('/kuesioner/submit', [PustakawanController::class, 'submit'])->name('kuesioner.submit');

    // Route untuk menampilkan halaman setelah jawaban berhasil disimpan
    Route::get('pustakawan/jawaban-tersimpan', [PustakawanController::class, 'jawabanTersimpan'])->name('pustakawan.jawabanTersimpan');
});
