<?php

namespace Database\Seeders;

use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  // Seeder untuk Kota
public function run()
{
    $kota = Kota::create(['nama_kota' => 'Bandung']);
    
    // Menambahkan Kecamatan
    $gedebage = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Gedebage']);
    $astanaanyar = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Astanaanyar']);
    $sumurbandung = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'sumurbandung']);
    
    // Menambahkan Kelurahan untuk Kecamatan Gedebage
    Kelurahan::create(['id_kecamatan' => $gedebage->id, 'nama_kelurahan' => 'Cisaranten Kidul']);
    Kelurahan::create(['id_kecamatan' => $gedebage->id, 'nama_kelurahan' => 'Rancabolang']);
    Kelurahan::create(['id_kecamatan' => $gedebage->id, 'nama_kelurahan' => 'Cimincring']);
    Kelurahan::create(['id_kecamatan' => $gedebage->id, 'nama_kelurahan' => 'Rancaumpang']);
    // Menambahkan kelurahan Astanaanyar
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Cibadak']);
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Karanganyar']);
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Nyengseret']);
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Panjunan']);
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Pelindung Hewan']);
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Karasak']);
    // Menambahkan untuk kelurahan Braga
    Kelurahan::create(['id_kecamatan' => $sumurbandung->id, 'nama_kelurahan' => 'Braga']);
    Kelurahan::create(['id_kecamatan' => $sumurbandung->id, 'nama_kelurahan' => 'Kebon Pisang']);
    Kelurahan::create(['id_kecamatan' => $sumurbandung->id, 'nama_kelurahan' => 'Merdeka']);
    Kelurahan::create(['id_kecamatan' => $sumurbandung->id, 'nama_kelurahan' => 'Babakan Ciamis']);
}

}
