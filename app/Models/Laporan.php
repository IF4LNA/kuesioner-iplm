<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans'; // Nama tabel
    protected $primaryKey = 'id_laporan'; // Kolom primary key

    // Tentukan kolom mana saja yang bisa diisi (mass assignment)
    protected $fillable = [
        'id_pertanyaan', 'id_perpustakaan', 'jenis_perpustakaan', 
        'kabupaten_kota', 'kecamatan', 'kelurahan', 'jumlah', 'id_user'
    ];

     // Relasi dengan Perpustakaan
     public function perpustakaan()
     {
         return $this->belongsTo(Perpustakaan::class, 'id_perpustakaan');
     }
 
     // Relasi dengan Kelurahan
     public function kelurahan()
     {
         return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
     }
 
     // Relasi dengan Pertanyaan
     public function pertanyaan()
     {
         return $this->belongsTo(Pertanyaan::class, 'id_pertanyaan');
     }
 
     // Relasi dengan Jawaban
     public function jawaban()
     {
         return $this->belongsTo(Jawaban::class, 'id_jawaban');
     }
 
     // Relasi dengan User (jika perlu, untuk menyimpan informasi pembuat laporan)
     public function user()
     {
         return $this->belongsTo(User::class, 'id_user');
     }
}

