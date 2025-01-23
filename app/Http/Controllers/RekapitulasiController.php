<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use App\Models\JenisPerpustakaan;
use Illuminate\Routing\Controller;

class RekapitulasiController extends Controller
{
    public function showRekap()
{
    // Ambil data subjenis di tabel jenis_perpustakaans
    $subjenisList = JenisPerpustakaan::select('subjenis')->distinct()->pluck('subjenis');

    // Ambil data pertanyaan dari database
    $pertanyaan = Pertanyaan::all();

    // Kelompokkan pertanyaan berdasarkan kategori
    $pertanyaanByKategori = $pertanyaan->groupBy('kategori');

    // Hitung jawaban berdasarkan pertanyaan dan kelompokkan sesuai subjenis
    $rekapData = [];
    foreach ($subjenisList as $subjenis) {
        $rekapData[$subjenis] = [];

        foreach ($pertanyaanByKategori as $kategori => $pertanyaanList) {
            foreach ($pertanyaanList as $pertanyaan) {
                // Hitung jumlah jawaban untuk subjenis tertentu
                $jumlahJawaban = Jawaban::where('id_pertanyaan', $pertanyaan->id_pertanyaan)
    ->whereHas('perpustakaan.jenis', function ($query) use ($subjenis) {
        $query->where('subjenis', $subjenis);
    })
    ->count();

                // Simpan hasil hitungan ke array
                $rekapData[$subjenis][$kategori][$pertanyaan->teks_pertanyaan] = $jumlahJawaban;
            }
        }
    }

    return view('admin.rekapitulasi', compact('subjenisList', 'pertanyaanByKategori', 'rekapData'));
}
}
