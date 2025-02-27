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
            'kontak' => 'required',
            'foto' => 'nullable|image',
            'kota' => 'required',
            'kecamatan' => 'required',
            'desa_kelurahan' => 'required',
            'alamat' => 'required',
        ]);

        // Proses upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('perpustakaan_foto', 'public');
        }

        // Simpan data perpustakaan
        Perpustakaan::create([
            'nama_perpustakaan' => $request->input('nama_perpustakaan'),
            'jenis' => $request->input('jenis_perpustakaan'),
            'npp' => $request->input('npp'),
            'kontak' => $request->input('kontak'),
            'foto' => $fotoPath,
            'id_kelurahan' => $request->input('desa_kelurahan'), // Sesuaikan nama input dengan form
            'alamat' => $request->input('alamat'),
        ]);

        // Redirect ke halaman isikuesioner setelah data disimpan
        return redirect()->route('isikuesioner')->with('success', 'Data berhasil disimpan. Silakan isi kuesioner.');
    }
}
