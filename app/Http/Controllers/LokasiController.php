<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LokasiController extends Controller
{
    public function showForm()
    {
        $kotas = Kota::all();
        return view('pustakawan.kuesioner', compact('kotas'));
    }
    
    public function getKecamatan($id_kota)
    {
        $kecamatans = Kecamatan::where('id_kota', $id_kota)->get();
        return response()->json($kecamatans);
    }

    public function getKelurahan($id_kecamatan)
    {
        $kelurahans = Kelurahan::where('id_kecamatan', $id_kecamatan)->get();
        return response()->json($kelurahans);
    }
}

