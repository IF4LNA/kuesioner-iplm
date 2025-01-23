<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\JenisPerpustakaan;
use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{
    public function showRekap()
{
    // Ambil semua subjenis
    $subjenisList = JenisPerpustakaan::select('subjenis')->distinct()->pluck('subjenis');

    // Ambil semua pertanyaan, dikelompokkan berdasarkan kategori
    $pertanyaanByKategori = Pertanyaan::all()->groupBy('kategori');

    // Rekapitulasi jumlah jawaban
    $rekapData = Jawaban::join('perpustakaans', 'jawabans.id_perpustakaan', '=', 'perpustakaans.id_perpustakaan')
        ->join('jenis_perpustakaans', 'perpustakaans.id_jenis', '=', 'jenis_perpustakaans.id_jenis')
        ->selectRaw('jenis_perpustakaans.subjenis, jawabans.id_pertanyaan, SUM(jawabans.jawaban) as total')
        ->groupBy('jenis_perpustakaans.subjenis', 'jawabans.id_pertanyaan')
        ->get();

    // Susun data menjadi array terstruktur
    $rekapArray = [];
    foreach ($rekapData as $data) {
        $rekapArray[$data->subjenis][$data->id_pertanyaan] = $data->total;
    }

    // Data untuk Blade
    return view('admin.rekapitulasi', compact('subjenisList', 'pertanyaanByKategori', 'rekapArray'));
}

}

