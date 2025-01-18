<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perpustakaan;
use App\Models\Jawaban;
use App\Models\Pertanyaan;

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
        // Tentukan nama view berdasarkan ID UPLM
        $viewName = 'admin.uplm' . $id; // 'admin.uplm1', 'admin.uplm2', ..., 'admin.uplm7'

        // Ambil data perpustakaan yang terkait dengan UPLM ini
        $query = Perpustakaan::with(['user', 'kelurahan.kecamatan']);

        // Tambahkan filter berdasarkan jenis
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis', $request->jenis);
        }

        // Ambil data sesuai filter
        $data = $query->get();

        // Pertanyaan spesifik jika diperlukan (misalnya, hanya untuk UPLM 2)
        $pertanyaan = null;
        if ($id == 1) {  // Misalnya, jika ID adalah 2, maka ambil data pertanyaan untuk UPLM 2
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 1')->get();
        } elseif ($id == 2) {
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 2')->get();
        } elseif ($id == 3) {
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 3')->get();
        } elseif ($id == 4) {
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 4')->get();
        } elseif ($id == 5) {
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 5')->get();
        } elseif ($id == 6) {
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 6')->get();
        } elseif ($id == 7) {
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 7')->get();
        }

        // Tampilkan data ke view
        return view($viewName, compact('data', 'pertanyaan', 'id'));
    }
}
