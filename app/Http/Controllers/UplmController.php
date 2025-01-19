<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perpustakaan;
use App\Models\JenisPerpustakaan;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\DB;

class UplmController extends Controller
{
    // Halaman UPLM
    public function showUplm($id)
{
    $viewName = 'admin.uplm' . $id;
    $data = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan'])->get();
    $pertanyaan = collect(); // Default data kosong
    $jawaban = collect(); // Default data kosong

    switch ($id) {
        case 1:
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 1')->get();
            break;
        case 2:
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 2')->get();
            break;
        case 3:
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 3')->get();
            break;
        case 4:
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 4')->get();
            break;
        case 5:
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 5')->get();
            break;
        case 6:
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 6')->get();
            break;
        case 7:
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 7')->get();
            break;
        default:
            return abort(404, 'Page not found');
    }

    // Cek apakah view ada
    if (view()->exists($viewName)) {
        return view($viewName, compact('data', 'pertanyaan', 'jawaban'));
    } else {
        return abort(404, 'Page not found');
    }
}

public function filterUplm(Request $request, $id)
{
    $viewName = 'admin.uplm' . $id;

    // Query untuk data Perpustakaan
    $query = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan']);

    if ($request->has('jenis') && $request->jenis != '') {
        $query->whereHas('jenis', function ($q) use ($request) {
            $q->where('jenis', $request->jenis);
        });
    }

    if ($request->has('subjenis') && $request->subjenis != '') {
        $query->whereHas('jenis', function ($q) use ($request) {
            $q->where('subjenis', $request->subjenis);
        });
    }

    $data = $query->get();

    // Filter pertanyaan berdasarkan tahun
    $pertanyaanQuery = Pertanyaan::where('kategori', 'UPLM ' . $id);
    if ($request->has('tahun') && $request->tahun != '') {
        $pertanyaanQuery->where('tahun', $request->tahun);
    }
    $pertanyaan = $pertanyaanQuery->get();

    // Ambil daftar tahun unik dari kolom 'tahun' di tabel 'pertanyaan'
    $years = Pertanyaan::select('tahun')->distinct()->pluck('tahun');

    // Ambil daftar jenis dan subjenis dari tabel jenis_perpustakaans
    $jenisList = JenisPerpustakaan::select('jenis')->distinct()->pluck('jenis');
    $subjenisList = JenisPerpustakaan::select('subjenis')->distinct()->pluck('subjenis');

    return view($viewName, compact('data', 'pertanyaan', 'id', 'years', 'jenisList', 'subjenisList'));
}

}
