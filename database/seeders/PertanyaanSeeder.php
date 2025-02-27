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
                'teks_pertanyaan' => 'Rekapitulasi Jumlah Judul Koleksi Tercetak ?',
                'kategori' => 'UPLM 2',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Rekapitulasi Jumlah Judul Koleksi Digital?',
                'kategori' => 'UPLM 2',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jumlah Pustakawan (Memiliki pendidikan diploma/sarjana ilmu perpustakaan/fungsional pustakawan/pustakawan non ASN)?',
                'kategori' => 'UPLM 3',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jumlah Pustakawan?',
                'kategori' => 'UPLM 3',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Nomor Kontak Pustakawan?',
                'kategori' => 'UPLM 3',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Nomor Kontak Tenaga Pustakawan?',
                'kategori' => 'UPLM 3',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Rata-rata jumlah kunjungan offline/onsite ke perpustakaan perhari selama satu tahun terakhir?',
                'kategori' => 'UPLM 4',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Rata-rata jumlah kunjungan online ke perpustakaan perhari selama satu tahun terakhir?',
                'kategori' => 'UPLM 4',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Apakah perpustakaan yang anda kelola sudah terakreditasi (sudah/belum)?',
                'kategori' => 'UPLM 5',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jika sudah sebutkan predikat akreditasi dan nomor akreditasi?',
                'kategori' => 'UPLM 5',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jika belum apakah anda mengetahui mengenai akreditasi perpustakaan?',
                'kategori' => 'UPLM 5',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jumlah Masyarakat yang Terlibat dalam Sosialisasi dan pemanfaatan perpustakaan secara offline/onsite selama satu tahun terakhir?',
                'kategori' => 'UPLM 6',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jumlah Masyarakat yang Terlibat dalam Sosialisasi dan pemanfaatan perpustakaan secara online selama satu tahun terakhir?',
                'kategori' => 'UPLM 6',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jumlah anggota perpustakaan yang dimiliki?',
                'kategori' => 'UPLM 7',
                'tahun' => 2025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];


        DB::table('pertanyaans')->insert($pertanyaan);
    }
}
