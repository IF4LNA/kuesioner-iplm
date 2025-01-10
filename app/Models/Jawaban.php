<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $table = 'jawabans'; // Nama tabel
    protected $primaryKey = 'id_jawaban'; // Primary key
    protected $fillable = ['id_pertanyaan', 'id_perpustakaan', 'jawaban', 'tahun'];


    public function pertanyaan()
    {
        // Relasi many-to-one ke model Pertanyaan
        return $this->belongsTo(Pertanyaan::class, 'id_pertanyaan', 'id_pertanyaan');
    }

    public function user()
    {
        // Relasi many-to-one ke model User
        return $this->belongsTo(User::class, 'id_akun', 'id');
    }

    public function perpustakaan()
    {
        return $this->belongsTo(Perpustakaan::class, 'id_perpustakaan', 'id_perpustakaan');
    }
    



}

