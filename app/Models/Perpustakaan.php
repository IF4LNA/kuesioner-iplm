<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Perpustakaan
class Perpustakaan extends Model
{
    use HasFactory;
    
    protected $table = 'perpustakaans';
    protected $primaryKey = 'id_perpustakaan'; // Menentukan primary key yang benar

    protected $fillable = [
        'nama_perpustakaan', 'npp', 'jenis', 'id_kelurahan', 'alamat', 'kontak', 'foto', 'id_akun'
    ];

    // Relasi dengan tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_akun');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }
}

