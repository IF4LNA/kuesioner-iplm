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
        
        // Ambil data untuk UPLM 1
        if ($id == 1) {
            $data = Perpustakaan::with(['user', 'kelurahan.kecamatan'])->get();
        } 
        // Jika ID adalah 2 hingga 7, tampilkan halaman kosong
        elseif ($id >= 2 && $id <= 7) {
            $data = collect(); // Mengembalikan koleksi kosong
        }
        // Jika ID tidak valid, bisa mengembalikan data kosong atau error
        else {
            return abort(404, 'Page not found');
        }

        // Cek apakah view ada
        if (view()->exists($viewName)) {
            return view($viewName, compact('data', 'pertanyaan'));
        } else {
            return abort(404, 'Page not found');
        }
    }

    // Method filter
    public function filterUplm1(Request $request)
    {
        // Ambil data untuk UPLM 1 dengan filter
        $query = Perpustakaan::with(['user', 'kelurahan.kecamatan']);

        // Tambahkan filter berdasarkan jenis
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis', $request->jenis);
        }

        $data = $query->get();

        return view('admin.uplm1', compact('data'));
    }
}
