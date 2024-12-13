<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Perpustakaan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PustakawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:pustakawan');
        $this->middleware('noCache');
    }

    //menampilkan halaman dashboard pustakawan
    public function index()
    {
        return view('pustakawan.dashboard');
    }

      //menampilkan halaman isi kuesioner pustakawan
    public function isikuesioner()
    {
        return view('pustakawan.isikuesioner');
    }

    //menampilkan data akun login, relasi kota/kec/kel di form
    public function showForm()
    {
        $user = auth()->user();
        $perpustakaan = $user->perpustakaan;
        $kotas = Kota::all();

        if ($perpustakaan) {
            return view('pustakawan.kuesioner', [
                'namaPerpustakaan' => $perpustakaan->nama_perpustakaan,
                'jenisPerpustakaan' => $perpustakaan->jenis,
                'kotas' => $kotas,
            ]);
        }

        return redirect()->route('home')->with('error', 'Perpustakaan tidak ditemukan untuk akun ini');
    }

    //mengirim data dari form ke database yang di redirect ke halaman isi kuesioner
    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:50',
            'npp' => 'required|string|max:50',
            'kontak' => 'nullable|string|max:50|regex:/^[0-9+\-\s]+$/',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desa_kelurahan' => 'required|integer|exists:kelurahans,id',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos', 'public');
        }

        $perpustakaan = auth()->user()->perpustakaan;
        if ($perpustakaan) {
            $perpustakaan->update([
                'alamat' => $request->alamat,
                'npp' => $request->npp,
                'kontak' => $request->kontak,
                'foto' => $fotoPath,
                'id_kelurahan' => $request->desa_kelurahan,
            ]);

            return redirect()->route('pustakawan.isikuesioner')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('pustakawan.isikuesioner')->with('error', 'Perpustakaan tidak ditemukan');
    }
}

