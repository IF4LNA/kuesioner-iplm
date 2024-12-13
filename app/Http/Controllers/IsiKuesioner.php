<?php

namespace App\Http\Controllers;

use App\Models\Perpustakaan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class IsiKuesioner extends Controller
{
    public function store(Request $request)
    {
        // Validasi data form
        $validated = $request->validate([
            'npp' => 'required',
            'no_telpon' => 'required',
            'foto' => 'required|image',
            'kota' => 'required',
            'kecamatan' => 'required',
            'desa_kelurahan' => 'required',
        ]);
    
        // Proses upload foto
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('perpustakaan_foto');
        }
    
        // Simpan data perpustakaan
        Perpustakaan::create([
            'nama_perpustakaan' => $request->input('nama_perpustakaan'),
            'jenis' => $request->input('jenis_perpustakaan'),
            'npp' => $request->input('npp'),
            'kontak' => $request->input('kontak'),
            'foto' => $fotoPath,
            'id_kelurahan' => $request->input('id_kelurahan'),
            'alamat' => 'alamat perpustakaan',
        ]);
    
        // Redirect ke halaman isikuesioner setelah data disimpan
        return redirect()->route('isikuesioner')->with('success', 'Data berhasil disimpan. Silakan isi kuesioner.');
    }
    
}
