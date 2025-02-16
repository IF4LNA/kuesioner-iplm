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

        $selectedPerpustakaan = $request->input('perpustakaan_id');
        $selectedTahun = $request->input('tahun');

        $monografi = collect();

        if ($selectedPerpustakaan && $selectedTahun) {
            $monografi = Pertanyaan::where('tahun', $selectedTahun)
                ->with(['jawaban' => function ($query) use ($selectedPerpustakaan) {
                    $query->where('id_perpustakaan', $selectedPerpustakaan);
                }])->get();
        }

        return view('admin.rekaperpus', compact('perpustakaans', 'tahunList', 'monografi', 'selectedPerpustakaan', 'selectedTahun'));
    }

    public function exportExcel(Request $request)
    {
        $selectedPerpustakaan = $request->input('perpustakaan_id');
        $selectedTahun = $request->input('tahun');
        return Excel::download(new RekapPerpusExport($selectedPerpustakaan, $selectedTahun), 'monografi_perpustakaan.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $selectedPerpustakaan = $request->input('perpustakaan_id');
        $selectedTahun = $request->input('tahun');

        $monografi = Pertanyaan::where('tahun', $selectedTahun)
            ->with(['jawaban' => function ($query) use ($selectedPerpustakaan) {
                $query->where('id_perpustakaan', $selectedPerpustakaan);
            }])->get();

            $pdf = PDF::loadView('admin.rekaperpus_pdf', compact('monografi', 'selectedPerpustakaan', 'selectedTahun'));

        return $pdf->download('monografi_perpustakaan.pdf');
    }
}
