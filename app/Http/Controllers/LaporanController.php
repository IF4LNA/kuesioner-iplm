<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function recap()
{
    // Mengambil semua laporan
    $laporans = Laporan::all();

    // Menyiapkan data untuk setiap laporan
    foreach ($laporans as $laporan) {
        $laporan->perpustakaan = $laporan->perpustakaan;
        $laporan->kelurahan = $laporan->kelurahan;
        $laporan->pertanyaan = $laporan->pertanyaan;
        $laporan->jawaban = $laporan->jawaban;
    }

    // Mengirimkan data ke view admin/rekapitulasi.blade.php
    return view('admin.rekapitulasi', compact('laporans'));
}

}
