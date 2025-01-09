<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaans'; // Jika menggunakan nama tabel custom (opsional)
    protected $primaryKey = 'id_pertanyaan'; // Menentukan primary key secara eksplisit
    protected $fillable = ['teks_pertanyaan', 'kategori', 'tahun'];

    public function jawaban()
    {
        // Relasi one-to-many ke model Jawaban
        return $this->hasMany(Jawaban::class, 'id_pertanyaan', 'id_pertanyaan');
    }
}


