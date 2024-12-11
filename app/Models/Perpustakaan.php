<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perpustakaan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_perpustakaan', 'jenis_perpustakaan', 'kota', 'kecamatan', 'desa_kelurahan', 'npp', 'no_telp', 'foto_pustakawan',
    ];

    // Relasi dengan tabel users
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
}
