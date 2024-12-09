<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PustakawanController extends Controller
{
    // Pastikan hanya pustakawan yang bisa mengakses halaman ini
    public function __construct()
    {
        $this->middleware('role:pustakawan');
        $this->middleware('noCache'); // Terapkan middleware untuk mencegah caching
    }

    // Halaman dashboard pustakawan
    public function index()
    {
        return view('pustakawan.dashboard');
    }

    //Halaman form data diri sebelum mengisi kuesioner
    public function kuesioner(){
        return view('pustakawan.kuesioner');
    }

   // Menangani kirim data dan redirect ke halaman isikuesioner
   public function kirimData(Request $request)
   {
       // Anda bisa menambahkan logika untuk menyimpan data ke database jika diperlukan

       // Setelah data dikirim, redirect ke halaman isikuesioner
       return redirect()->route('putakawan.isikuesioner');
   }
}

