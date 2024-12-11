<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perpustakaan extends Model
{
    use HasFactory;
    protected $table = 'perpustakaans';
    protected $fillable = [
        'nama_perpustakaan', 'npp', 'jenis', 'id_kelurahan', 'alamat', 'kontak', 'foto', 'id_akun'
    ];

    // Relasi dengan tabel users
    public function users()
    {
        return $this->belongsTo(User::class, 'id_akun');
    }
    
}
