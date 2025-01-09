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
                $data = Pertanyaan::all();
                break;
            case 4:
                // Logika untuk UPLM 4
                $data = Perpustakaan::select('id', 'nama')->get();
                break;
            case 5:
                // Logika untuk UPLM 5
                $data = Jawaban::where('tahun', date('Y'))->get();
                break;
            case 6:
                // Logika untuk UPLM 6
                $data = Perpustakaan::withCount('jawaban')->get();
                break;
            case 7:
                // Logika untuk UPLM 7
                $data = Jawaban::whereHas('pertanyaan', function($query) {
                    $query->where('kategori', 'specific_category');
                })->get();
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
}
