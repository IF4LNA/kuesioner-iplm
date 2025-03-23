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
                'teks_pertanyaan' => 'Jumlah Judul Koleksi Buku Tercetak Saat Ini',
                'kategori' => 'UPLM 2',
                'tahun' => 2025,
                'tipe_jawaban' => 'number',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jumlah Judul Koleksi Buku Digital Saat Ini',
                'kategori' => 'UPLM 2',
                'tahun' => 2025,
                'tipe_jawaban' => 'number',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jumlah Pustakawan Saat Ini',
                'kategori' => 'UPLM 3',
                'tahun' => 2025,
                'tipe_jawaban' => 'number',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Rata-rata jumlah kunjungan offline/onsite ke perpustakaan perhari selama satu tahun terakhir',
                'kategori' => 'UPLM 4',
                'tahun' => 2025,
                'tipe_jawaban' => 'number',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Rata-rata jumlah kunjungan online ke perpustakaan perhari selama satu tahun terakhir',
                'kategori' => 'UPLM 4',
                'tahun' => 2025,
                'tipe_jawaban' => 'number',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Apakah perpustakaan yang anda kelola sudah terakreditasi (sudah/belum)',
                'kategori' => 'UPLM 5',
                'tahun' => 2025,
                'tipe_jawaban' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jika sudah sebutkan predikat akreditasi dan nomor akreditasi',
                'kategori' => 'UPLM 5',
                'tahun' => 2025,
                'tipe_jawaban' => 'number',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jika belum apakah anda mengetahui mengenai akreditasi perpustakaan(iya/tidak)',
                'kategori' => 'UPLM 5',
                'tahun' => 2025,
                'tipe_jawaban' => 'radio',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jumlah Masyarakat yang Terlibat dalam Sosialisasi dan pemanfaatan perpustakaan secara offline/onsite selama satu tahun terakhir',
                'kategori' => 'UPLM 6',
                'tahun' => 2025,
                'tipe_jawaban' => 'number',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jumlah Masyarakat yang Terlibat dalam Sosialisasi dan pemanfaatan perpustakaan secara online selama satu tahun terakhir',
                'kategori' => 'UPLM 6',
                'tahun' => 2025,
                'tipe_jawaban' => 'number',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Apakah pernah mengadakan kegiatan sosialisasi (Komunikasi, Informasi dan Edukasi) dan pemanfaatan perpustakaan yang melibatkan siswa/mahasiswa/pegawai/masyarakat/dll. baik onsite maupun online (termasuk workshop, pelatihan, bimbingan teknis, bedah buku, klub membaca, dan kegiatan bersama komunitas) selama satu tahun terakhir',
                'kategori' => 'UPLM 6',
                'tahun' => 2025,
                'tipe_jawaban' => 'radio',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Sebutkan nama kegiatan tersebut',
                'kategori' => 'UPLM 6',
                'tahun' => 2025,
                'tipe_jawaban' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Berapa jumlah peserta kegiatan tersebut',
                'kategori' => 'UPLM 6',
                'tahun' => 2025,
                'tipe_jawaban' => 'number',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'teks_pertanyaan' => 'Jumlah anggota perpustakaan yang dimiliki',
                'kategori' => 'UPLM 7',
                'tahun' => 2025,
                'tipe_jawaban' => 'number',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];


        DB::table('pertanyaans')->insert($pertanyaan);
    }
}