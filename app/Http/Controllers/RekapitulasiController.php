<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPerpustakaan;
use App\Models\Pertanyaan;
use Illuminate\Routing\Controller;

class RekapitulasiController extends Controller
{
    public function showRekap()
    {
        //Ambil data subjenis di tabel jenis_perpustakaans
        $subjenisList = JenisPerpustakaan::select('subjenis')->distinct()->pluck('subjenis');

        // Ambil data pertanyaan dari database berdasarkan kategori
        $pertanyaan = Pertanyaan::all();

        // Kelompokkan pertanyaan berdasarkan kategori
        $pertanyaanByKategori = $pertanyaan->groupBy('kategori');

        return view('admin.rekapitulasi', compact('subjenisList', 'pertanyaanByKategori')); // Kirim kedua variabel
    }
}
