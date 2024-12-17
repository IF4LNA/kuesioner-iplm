<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PertanyaanSeeder extends Seeder
{
    public function run()
    {
        $pertanyaan = [
            [
                'teks_pertanyaan' => 'Berapa jumlah koleksi buku di perpustakaan tempat anda bekerja?',
                'kategori' => 'UPLM 1',
                'tahun' => 2024,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Bagaimana fasilitas yang tersedia di perpustakaan?',
                'kategori' => 'UPLM 2',
                'tahun' => 2024,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Apakah koleksi buku di perpustakaan sudah memadai?',
                'kategori' => 'UPLM 3',
                'tahun' => 2023,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Bagaimana kebersihan dan kenyamanan ruangan perpustakaan?',
                'kategori' => 'UPLM 4',
                'tahun' => 2023,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Bagaimana keramahan staf perpustakaan?',
                'kategori' => 'UPLM 5',
                'tahun' => 2022,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('pertanyaans')->insert($pertanyaan);
    }
}
