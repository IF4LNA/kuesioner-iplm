<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perpustakaan;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use Barryvdh\DomPDF\Facade\Pdf;

class MonografiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil ID akun yang sedang login
        $idAkun = auth()->user()->id;

        // Ambil data perpustakaan yang sesuai dengan akun login
        $perpustakaan = Perpustakaan::where('id_akun', $idAkun)
            ->with(['jenis', 'kelurahan.kecamatan.kota'])
            ->first();

        // Jika tidak ada perpustakaan terkait akun, kembalikan error atau redirect
        if (!$perpustakaan) {
            return redirect()->back()->with('error', 'Data perpustakaan tidak ditemukan.');
        }

        // Ambil daftar tahun dari tabel pertanyaans
        $tahunList = Pertanyaan::distinct()->pluck('tahun')->sort();

        // Pilih tahun dari request atau default ke tahun terbaru
        $tahunTerpilih = $request->query('tahun', $tahunList->last());

        // Ambil pertanyaan berdasarkan tahun
        $pertanyaans = Pertanyaan::where('tahun', $tahunTerpilih)->get();

        // Ambil jawaban yang sesuai dengan perpustakaan & tahun
        $jawabans = Jawaban::where('id_perpustakaan', $perpustakaan->id_perpustakaan)
            ->where('tahun', $tahunTerpilih)
            ->pluck('jawaban', 'id_pertanyaan');

        return view('pustakawan.monografi', compact(
            'perpustakaan', 'tahunList', 'tahunTerpilih', 'pertanyaans', 'jawabans'
        ));
    }

    public function exportPDF($tahun)
{
    // Ambil akun yang sedang login
    $idAkun = auth()->user()->id;

    // Ambil data perpustakaan yang sesuai dengan akun login
    $perpustakaan = Perpustakaan::where('id_akun', $idAkun)
        ->with(['jenis', 'kelurahan.kecamatan.kota'])
        ->first();

    if (!$perpustakaan) {
        return redirect()->back()->with('error', 'Data perpustakaan tidak ditemukan.');
    }

    // Ambil pertanyaan beserta jawaban yang sesuai dengan tahun & perpustakaan terkait
    $monografi = Pertanyaan::where('tahun', $tahun)
        ->with(['jawaban' => function ($query) use ($perpustakaan, $tahun) {
            $query->where('id_perpustakaan', $perpustakaan->id_perpustakaan)
                  ->where('tahun', $tahun);
        }])
        ->get();

    // Load view PDF
    $pdf = PDF::loadView('pustakawan.monografip_pdf', compact('perpustakaan', 'monografi', 'tahun'))
        ->setPaper('A4', 'portrait');

    // Nama file PDF
    $fileName = 'Monografi_Perpus_' . str_replace(' ', '_', $perpustakaan->nama_perpustakaan) . "_$tahun.pdf";

    // Unduh PDF
    return $pdf->download($fileName);
}

    
}

