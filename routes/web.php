<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UplmController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\PustakawanController;
use App\Http\Controllers\RekapitulasiController;
use App\Exports\RekapitulasiExport;
use App\Http\Controllers\ActivityController;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\RekapPerpusController;
use App\Http\Controllers\MonografiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminProfileController;


// Rute login dan logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Menampilkan form lupa password
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');

// Mengirim email reset password
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// Menampilkan form reset password
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');

// Proses reset password
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Memproses reset password
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');

// Rute umum (tanpa autentikasi)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/bantuan', [HomeController::class, 'bantuan'])->name('bantuan');

// Rute dengan autentikasi dan peran
Route::middleware('auth')->group(function () {
    // Dashboard admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });


    // Dashboard pustakawan
    Route::middleware('role:pustakawan')->group(function () {
        Route::get('/pustakawan/dashboard', [PustakawanController::class, 'index'])->name('pustakawan.dashboard');
    });
});


// route side-bar
Route::middleware(['auth'])->group(function () {

    Route::get('/manage-users', [AdminController::class, 'manageUsers'])->name('manage.users');

    //edit uplm
    Route::get('/uplm/{id}/jawaban/{jawaban}/edit', [UplmController::class, 'editJawaban'])->name('uplm.jawaban.edit');
    Route::put('/uplm/{id}/jawaban/{jawaban}', [UplmController::class, 'updateJawaban'])->name('uplm.jawaban.update');
    Route::delete('/uplm/{id}/jawaban/{jawaban}', [UplmController::class, 'deleteJawaban'])->name('uplm.jawaban.delete');

    //filter dan route uplm 1-7
    Route::get('/uplm/{id}', [UplmController::class, 'filterUplm'])->name('uplm');
    Route::get('/uplm/{id}/filterByYear', [UplmController::class, 'filterByYear'])->name('uplm.filterByYear');

    //buat akun
    Route::get('/user/create', [AdminController::class, 'createUser'])->name('user.create');

    // route buat akun
    Route::get('/admin/create-account', [AdminController::class, 'createAccountForm'])->name('admin.create-account');
    Route::post('/admin/create-account', [AdminController::class, 'storeAccount'])->name('admin.store-account');

    //profiladmin
    Route::middleware('auth')->group(function () {
        Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile');
        Route::post('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    });

    // route menampilkan data subjenis di form input
    Route::get('/getSubjenis/{jenis}', [AdminController::class, 'getSubjenis']);

    //route rekapitulasi
    Route::get('/rekapitulasi', [RekapitulasiController::class, 'showRekap'])->name('rekapitulasi');
    // Route::get('/rekapitulasi', [RekapitulasiController::class, 'showRekap'])->name('rekapitulasi');

    Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');

    //export excel uplm 1
    Route::get('/uplm/export/{id}', [UplmController::class, 'exportExcel'])->name('uplm.exportExcel');

    //export pdf uplm 1
    Route::get('/uplm/{id}/exportPdf', [UplmController::class, 'exportPdf'])
        ->name('uplm.exportPdf1');

    //export pdf uplm 2-7
    Route::get('/uplm/{id}/exportPdf/{kategori}', [UplmController::class, 'exportUplmPdf'])->name('uplm.exportPdf');

    //export rekap
    Route::get('/export-rekapitulasi/{tahun}', function ($tahun) {
        return Excel::download(new RekapitulasiExport($tahun), "Rekapitulasi_UPLM_Kota_Bandung_$tahun.xlsx");
    })->name('export.rekapitulasi');



    Route::get('/admin/rekapitulasi-perpustakaan', [RekapPerpusController::class, 'index'])
        ->name('admin.rekaperpus');

    Route::get('/export/rekapitulasi/pdf/{tahun}', [RekapitulasiController::class, 'exportPDF'])->name('export.rekapitulasi.pdf');

    // Route::get('/admin/rekaperpus', [RekapPerpusController::class, 'index'])->name('admin.rekaperpus');
    Route::get('/admin/rekaperpus/export/excel', [RekapPerpusController::class, 'exportExcel'])->name('admin.rekaperpus.export.excel');
    Route::get('/admin/rekaperpus/export/pdf', [RekapPerpusController::class, 'exportPdf'])->name('admin.rekaperpus.export.pdf');

    //route aktivitas admin
    Route::get('activity-logs', [ActivityController::class, 'showActivityLogs'])->name('admin.activity-logs');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //search monografi admin
    Route::get('/perpustakaans/search', [RekapPerpusController::class, 'search'])->name('perpustakaans.search');

    //route edit pertanyaan
    Route::get('/questions/{id}/edit', [PertanyaanController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{id}', [PertanyaanController::class, 'update'])->name('questions.update');

    //route membuat dan menghapus pertanyaan
    Route::get('/questions/create', [PertanyaanController::class, 'create'])->name('questions.create');
    Route::post('/questions', [PertanyaanController::class, 'store'])->name('questions.store');
    Route::delete('/questions/{id}', [PertanyaanController::class, 'destroy'])->name('questions.destroy');

    Route::get('/questions/get-by-year/{tahun}', [PertanyaanController::class, 'getByYear']);
    Route::post('/questions/copy', [PertanyaanController::class, 'copy'])->name('questions.copy');
});

// route halaman pustakawan
Route::middleware(['auth'])->group(function () {
    Route::get('/form/data', [PustakawanController::class, 'showForm'])->name('form.data');

    Route::get('/monografi', [MonografiController::class, 'index'])->name('monografi.index');

    //export pdf monografi pustakawan
    Route::get('/pustakawan/monografi/export-pdf/{tahun}', [MonografiController::class, 'exportPDF'])
        ->name('pustakawan.monografi.export.pdf')
        ->middleware('auth'); // Pastikan hanya user login yang bisa mengakses
    Route::get('/monografi/exportPDF/{tahun}', [MonografiController::class, 'exportPDF'])->name('monografi.exportPDF');

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
