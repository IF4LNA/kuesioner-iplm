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
        $data = collect(); // Default data kosong

        switch ($id) {
            case 1:
                $data = Perpustakaan::with(['user', 'kelurahan.kecamatan'])->get();
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 1')->get();
                break;
            case 2:
            // Logika untuk UPLM 2
            $data = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan'])->get();
            $jawaban = Jawaban::with(['pertanyaan']) // Eager load relasi pertanyaan dan perpustakaan
                // ->whereHas('pertanyaan', function ($query) {
                //     $query->where('kategori', 'UPLM 2');
                // })
                ->get();

            // Mengambil pertanyaan untuk kategori UPLM 2
            $pertanyaan = Pertanyaan::where('kategori', 'UPLM 2')->get();
                break;
            case 3:
                // Logika untuk UPLM 3
                $data = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan'])->get();
                $jawaban = Jawaban::with(['pertanyaan']) // Eager load relasi pertanyaan dan perpustakaan
                    // ->whereHas('pertanyaan', function ($query) {
                    //     $query->where('kategori', 'UPLM 2');
                    // })
                    ->get();
    
                // Mengambil pertanyaan untuk kategori UPLM 2
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 3')->get();
                break;
            case 4:
                // Logika untuk UPLM 4
                $data = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan'])->get();
                $jawaban = Jawaban::with(['pertanyaan']) // Eager load relasi pertanyaan dan perpustakaan
                    // ->whereHas('pertanyaan', function ($query) {
                    //     $query->where('kategori', 'UPLM 2');
                    // })
                    ->get();
    
                // Mengambil pertanyaan untuk kategori UPLM 2
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 4')->get();
                break;
            case 5:
                // Logika untuk UPLM 5
                $data = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan'])->get();
                $jawaban = Jawaban::with(['pertanyaan']) // Eager load relasi pertanyaan dan perpustakaan
                    // ->whereHas('pertanyaan', function ($query) {
                    //     $query->where('kategori', 'UPLM 2');
                    // })
                    ->get();
    
                // Mengambil pertanyaan untuk kategori UPLM 2
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 5')->get();
                break;
            case 6:
                // Logika untuk UPLM 6
                $data = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan'])->get();
                $jawaban = Jawaban::with(['pertanyaan']) // Eager load relasi pertanyaan dan perpustakaan
                    // ->whereHas('pertanyaan', function ($query) {
                    //     $query->where('kategori', 'UPLM 2');
                    // })
                    ->get();
    
                // Mengambil pertanyaan untuk kategori UPLM 2
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 6')->get();
                break;
            case 7:
                // Logika untuk UPLM 7
                $data = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan'])->get();
                $jawaban = Jawaban::with(['pertanyaan']) // Eager load relasi pertanyaan dan perpustakaan
                    // ->whereHas('pertanyaan', function ($query) {
                    //     $query->where('kategori', 'UPLM 2');
                    // })
                    ->get();
    
                // Mengambil pertanyaan untuk kategori UPLM 2
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 7')->get();
                break;
            default:
                return abort(404, 'Page not found');
        }

        // Cek apakah view ada
        if (view()->exists($viewName)) {
            return view($viewName, compact('data', 'pertanyaan'));
        } else {
            return abort(404, 'Page not found');
        }
    }

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

    public function filterUplm2(Request $request)
    {
        $viewName = 'admin.uplm2';
        // Ambil data untuk UPLM 1 dengan filter
        $query = Perpustakaan::with(['user', 'kelurahan.kecamatan']);
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 2')->get();

        // Tambahkan filter berdasarkan jenis
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis', $request->jenis);
        }

        $data = $query->get();

        return view($viewName, compact('data', 'pertanyaan'));
    }
    
}
