<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perpustakaan;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use App\Models\JenisPerpustakaan;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RekapPerpusExport;

class RekapPerpusController extends Controller
{
    public function index(Request $request)
    {
        $perpustakaans = Perpustakaan::with('jenis')->get();
        $tahunList = Pertanyaan::select('tahun')->distinct()->pluck('tahun');

        $selectedPerpustakaan = (int) $request->input('perpustakaan_id');
        $selectedTahun = $request->input('tahun');

        $monografi = collect();

        if ($selectedPerpustakaan && $selectedTahun) {
            $perpustakaan = Perpustakaan::with(['jenis', 'kelurahan.kecamatan.kota'])
                ->where('id_perpustakaan', $selectedPerpustakaan)
                ->first();
        
            $monografi = Pertanyaan::where('tahun', $selectedTahun)
                ->with(['jawaban' => function ($query) use ($selectedPerpustakaan) {
                    $query->where('id_perpustakaan', $selectedPerpustakaan);
                }])->get();
        } else {
            $perpustakaan = null;
        }
        

        return view('admin.rekaperpus', compact('perpustakaans', 'tahunList', 'monografi', 'selectedPerpustakaan', 'selectedTahun', 'perpustakaan'));

    }

    public function exportExcel(Request $request)
    {
        $selectedPerpustakaan = $request->input('perpustakaan_id');
        $selectedTahun = $request->input('tahun');
        return Excel::download(new RekapPerpusExport($selectedPerpustakaan, $selectedTahun), 'monografi_perpustakaan.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $selectedPerpustakaan = $request->input('perpustakaan_id');
        $selectedTahun = $request->input('tahun');
    
        // Ambil data perpustakaan beserta relasi lengkap
        $perpustakaan = Perpustakaan::with([
            'jenis', // Relasi untuk jenis & subjenis
            'kelurahan.kecamatan.kota' // Relasi untuk wilayah
        ])->where('id_perpustakaan', $selectedPerpustakaan)->first();
    
        // Ambil data monografi berdasarkan tahun dan perpustakaan
        $monografi = Pertanyaan::where('tahun', $selectedTahun)
            ->with(['jawaban' => function ($query) use ($selectedPerpustakaan) {
                $query->where('id_perpustakaan', $selectedPerpustakaan);
            }])->get();
    
        // Pastikan tidak ada error saat membuat nama file
        $fileName = 'Monografi_Perpus_' . str_replace(' ', '_', $perpustakaan->nama_perpustakaan ?? 'Unknown') . "_$selectedTahun.pdf";
    
        // Buat PDF dengan layout yang rapi
        $pdf = Pdf::loadView('admin.rekaperpus_pdf', compact('perpustakaan', 'monografi', 'selectedTahun'))
            ->setPaper('a4', 'portrait');
    
        return $pdf->download($fileName);
    }
    
    
    
}
