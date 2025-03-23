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
            ->with([
                'jenis:id,nama_jenis',
                'kelurahan:id,nama_kelurahan,kecamatan_id',
                'kelurahan.kecamatan:id,nama_kecamatan,kota_id',
                'kelurahan.kecamatan.kota:id,nama_kota'
            ])
            ->select('id_perpustakaan', 'id_akun', 'nama_perpustakaan', 'id_jenis', 'id_kelurahan')
            ->first();

        // Jika tidak ada perpustakaan terkait akun, kembalikan pesan error
        if (!$perpustakaan) {
            return redirect()->back()->with('error', 'Data perpustakaan belum diisi. Silakan isi data perpustakaan terlebih dahulu.');
        }

        // Jika ada relasi yang null (misalnya kelurahan), kembalikan pesan error
        if (!$perpustakaan->kelurahan || !$perpustakaan->kelurahan->kecamatan || !$perpustakaan->kelurahan->kecamatan->kota) {
            return redirect()->back()->with('error', 'Data perpustakaan belum lengkap. Silakan lengkapi data perpustakaan terlebih dahulu.');
        }

        // Ambil daftar tahun dari tabel pertanyaans
        $tahunList = Pertanyaan::distinct()->pluck('tahun')->sort();

        // Pilih tahun dari request atau default ke tahun terbaru
        $tahunTerpilih = $request->query('tahun', $tahunList->last());

        // Ambil pertanyaan berdasarkan tahun
        $pertanyaans = Pertanyaan::where('tahun', $tahunTerpilih)->get();

        // Ambil jawaban yang sesuai dengan perpustakaan & tahun
        Jawaban::where('id_perpustakaan', $perpustakaan->id_perpustakaan)
            ->where('tahun', $tahunTerpilih)
            ->pluck('jawaban', 'id_pertanyaan');


        return view('pustakawan.monografi', compact(
            'perpustakaan',
            'tahunList',
            'tahunTerpilih',
            'pertanyaans',
            'jawabans'
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
            ->with(['jawaban' => function ($query) use ($perpustakaan) {
                $query->where('id_perpustakaan', $perpustakaan->id_perpustakaan);
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
