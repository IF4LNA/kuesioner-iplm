<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JenisPerpustakaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            // Jenis Umum
            ['jenis' => 'Umum', 'subjenis' => 'Kab/Kota'],
            ['jenis' => 'Umum', 'subjenis' => 'Kecamatan'],
            ['jenis' => 'Umum', 'subjenis' => 'Desa/Kel'],

            // Jenis Sekolah
            ['jenis' => 'Sekolah', 'subjenis' => 'SD'],
            ['jenis' => 'Sekolah', 'subjenis' => 'MI'],
            ['jenis' => 'Sekolah', 'subjenis' => 'SMP'],
            ['jenis' => 'Sekolah', 'subjenis' => 'MTs'],
            ['jenis' => 'Sekolah', 'subjenis' => 'SMA'],
            ['jenis' => 'Sekolah', 'subjenis' => 'SMK'],
            ['jenis' => 'Sekolah', 'subjenis' => 'MA'],

            // Jenis Perguruan Tinggi (Tidak ada subjenis)
            ['jenis' => 'Perguruan Tinggi', 'subjenis' => null],

            // Jenis Khusus (Tidak ada subjenis)
            ['jenis' => 'Khusus', 'subjenis' => null],
        ];

        // Menyisipkan data ke tabel jenis_perpustakaans
        DB::table('jenis_perpustakaans')->insert($data);
    }
}
