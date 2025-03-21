<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\JenisPerpustakaan;
use Illuminate\Http\Request;
use App\Exports\RekapitulasiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
    
        // Rekapitulasi jumlah jawaban berdasarkan tipe jawaban
        $rekapData = Jawaban::join('perpustakaans', 'jawabans.id_perpustakaan', '=', 'perpustakaans.id_perpustakaan')
            ->join('jenis_perpustakaans', 'perpustakaans.id_jenis', '=', 'jenis_perpustakaans.id_jenis')
            ->join('pertanyaans', 'jawabans.id_pertanyaan', '=', 'pertanyaans.id_pertanyaan')
            ->selectRaw('jenis_perpustakaans.jenis, jenis_perpustakaans.subjenis, jawabans.id_pertanyaan, pertanyaans.tipe_jawaban,
                         SUM(CASE 
                             WHEN pertanyaans.tipe_jawaban = \'number\' THEN CAST(jawabans.jawaban AS UNSIGNED)
                             ELSE 0
                         END) as total_angka,
                         COUNT(CASE 
                             WHEN pertanyaans.tipe_jawaban IN (\'text\', \'radio\') THEN 1
                             ELSE NULL
                         END) as total_responden')
            ->whereIn('jawabans.id_pertanyaan', $pertanyaanByKategori->flatten()->pluck('id_pertanyaan'))
            ->groupBy('jenis_perpustakaans.jenis', 'jenis_perpustakaans.subjenis', 'jawabans.id_pertanyaan', 'pertanyaans.tipe_jawaban')
            ->get();
    
        // Ambil data jumlah perpustakaan
        $perpustakaanData = \App\Models\Perpustakaan::join('jawabans', 'perpustakaans.id_perpustakaan', '=', 'jawabans.id_perpustakaan')
            ->join('jenis_perpustakaans', 'perpustakaans.id_jenis', '=', 'jenis_perpustakaans.id_jenis')
            ->selectRaw('jenis_perpustakaans.jenis, jenis_perpustakaans.subjenis, COUNT(DISTINCT perpustakaans.id_perpustakaan) as total_perpustakaan')
            ->whereNotNull('perpustakaans.nama_perpustakaan')
            ->where('jawabans.tahun', $tahunTerpilih)
            ->groupBy('jenis_perpustakaans.jenis', 'jenis_perpustakaans.subjenis')
            ->get();
    
        // Susun data menjadi array terstruktur
        $rekapArray = [];
        foreach ($rekapData as $data) {
            $rekapArray[$data->jenis][$data->subjenis][$data->id_pertanyaan] = [
                'total_angka' => intval($data->total_angka),  // Konversi ke integer
                'total_responden' => intval($data->total_responden)
            ];
        }
    
        // Tambahkan data jumlah perpustakaan ke array
        $jumlahPerpustakaan = [];
        foreach ($perpustakaanData as $data) {
            $jumlahPerpustakaan[$data->jenis][$data->subjenis] = $data->total_perpustakaan;
        }
    
        return view('admin.rekapitulasi', compact('tahunList', 'tahunTerpilih', 'jenisList', 'pertanyaanByKategori', 'rekapArray', 'jumlahPerpustakaan'));
    }
    
    public function exportRekap($tahun)
    {
        return Excel::download(new RekapitulasiExport($tahun), "Rekapitulasi_UPLM_Kota_Bandung_$tahun.xlsx");
    }  
    
    public function exportPDF($tahun)
    {
        // Ambil data tahun dan pertanyaan
        $tahunList = Pertanyaan::select('tahun')->distinct()->pluck('tahun');
        $tahunTerpilih = $tahun;
        $jenisList = JenisPerpustakaan::select('jenis', 'subjenis')->get()->groupBy('jenis');
        $pertanyaanByKategori = Pertanyaan::where('tahun', $tahunTerpilih)->get()->groupBy('kategori');
    
        // Ambil rekap jawaban
        $rekapData = Jawaban::join('perpustakaans', 'jawabans.id_perpustakaan', '=', 'perpustakaans.id_perpustakaan')
            ->join('jenis_perpustakaans', 'perpustakaans.id_jenis', '=', 'jenis_perpustakaans.id_jenis')
            ->join('pertanyaans', 'jawabans.id_pertanyaan', '=', 'pertanyaans.id_pertanyaan')
            ->selectRaw('jenis_perpustakaans.jenis, jenis_perpustakaans.subjenis, jawabans.id_pertanyaan, pertanyaans.tipe_jawaban,
                         COALESCE(SUM(CASE 
                             WHEN pertanyaans.tipe_jawaban = \'number\' THEN CAST(jawabans.jawaban AS UNSIGNED)
                             ELSE 0
                         END), 0) as total_angka,
                         COALESCE(COUNT(CASE 
                             WHEN pertanyaans.tipe_jawaban IN (\'text\', \'radio\') THEN 1
                             ELSE NULL
                         END), 0) as total_responden')
            ->whereIn('jawabans.id_pertanyaan', $pertanyaanByKategori->flatten()->pluck('id_pertanyaan'))
            ->groupBy('jenis_perpustakaans.jenis', 'jenis_perpustakaans.subjenis', 'jawabans.id_pertanyaan', 'pertanyaans.tipe_jawaban')
            ->get();
    
        // Ambil data jumlah perpustakaan
        $perpustakaanData = \App\Models\Perpustakaan::join('jawabans', 'perpustakaans.id_perpustakaan', '=', 'jawabans.id_perpustakaan')
            ->join('jenis_perpustakaans', 'perpustakaans.id_jenis', '=', 'jenis_perpustakaans.id_jenis')
            ->selectRaw('jenis_perpustakaans.jenis, jenis_perpustakaans.subjenis, COUNT(DISTINCT perpustakaans.id_perpustakaan) as total_perpustakaan')
            ->whereNotNull('perpustakaans.nama_perpustakaan')
            ->where('jawabans.tahun', $tahunTerpilih)
            ->groupBy('jenis_perpustakaans.jenis', 'jenis_perpustakaans.subjenis')
            ->get();
    
        // Konversi data ke array untuk tampilan di Blade
        $rekapArray = [];
        foreach ($rekapData as $data) {
            $rekapArray[$data->jenis][$data->subjenis][$data->id_pertanyaan] = [
                'total_angka' => intval($data->total_angka),  // Konversi ke integer
                'total_responden' => intval($data->total_responden)
            ];
        }
    
        $jumlahPerpustakaan = [];
        foreach ($perpustakaanData as $data) {
            $jumlahPerpustakaan[$data->jenis][$data->subjenis] = intval($data->total_perpustakaan);
        }
    
        // Render tampilan PDF
        $pdf = Pdf::loadView('admin.rekapitulasi_pdf', compact(
            'tahunList', 'tahunTerpilih', 'jenisList', 'pertanyaanByKategori', 'rekapArray', 'jumlahPerpustakaan'
        ))->setPaper('a4', 'landscape');
    
        return $pdf->download("Rekapitulasi_UPLM_Kota_Bandung_{$tahun}.pdf");
    }
}