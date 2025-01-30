<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\JenisPerpustakaan;
use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{
    public function showRekap(Request $request)
    {
        // Ambil daftar tahun dari tabel pertanyaan
        $tahunList = Pertanyaan::select('tahun')->distinct()->pluck('tahun');
    
        // Tahun yang dipilih (default ke tahun terbaru jika tidak ada yang dipilih)
        $tahunTerpilih = $request->input('tahun', $tahunList->max());
    
        // Ambil semua jenis dan subjenis perpustakaan dalam format terstruktur
        $jenisList = JenisPerpustakaan::select('jenis', 'subjenis')->get()->groupBy('jenis');
    
        // Ambil pertanyaan berdasarkan tahun yang dipilih
        $pertanyaanByKategori = Pertanyaan::where('tahun', $tahunTerpilih)->get()->groupBy('kategori');
    
        // Rekapitulasi jumlah jawaban
        $rekapData = Jawaban::join('perpustakaans', 'jawabans.id_perpustakaan', '=', 'perpustakaans.id_perpustakaan')
        ->join('jenis_perpustakaans', 'perpustakaans.id_jenis', '=', 'jenis_perpustakaans.id_jenis')
        ->selectRaw('jenis_perpustakaans.jenis, jenis_perpustakaans.subjenis, jawabans.id_pertanyaan, 
                     SUM(CASE 
                         WHEN jawabans.jawaban REGEXP \'^[0-9]+$\' THEN jawabans.jawaban 
                         ELSE 0 
                     END) as total_angka,
                     COUNT(CASE 
                         WHEN jawabans.jawaban REGEXP \'^[^0-9]+$\' THEN 1  -- Hanya huruf
                         WHEN jawabans.jawaban REGEXP \'[A-Za-z]+\' THEN 1 -- Mengandung huruf
                         WHEN jawabans.jawaban REGEXP \'[0-9]+\' AND jawabans.jawaban REGEXP \'[^\d]\' THEN 1 -- Mengandung angka dan simbol
                         ELSE NULL 
                     END) as total_responden')
        ->whereIn('jawabans.id_pertanyaan', $pertanyaanByKategori->flatten()->pluck('id_pertanyaan'))
        ->groupBy('jenis_perpustakaans.jenis', 'jenis_perpustakaans.subjenis', 'jawabans.id_pertanyaan')
        ->get();
    
    
    
        // Susun data menjadi array terstruktur
        $rekapArray = [];
        foreach ($rekapData as $data) {
            $rekapArray[$data->jenis][$data->subjenis][$data->id_pertanyaan] = [
                'total_angka' => $data->total_angka,
                'total_responden' => $data->total_responden
            ];
        }
    
        return view('admin.rekapitulasi', compact('tahunList', 'tahunTerpilih', 'jenisList', 'pertanyaanByKategori', 'rekapArray'));
    }
    
    
    

}

