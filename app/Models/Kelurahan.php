<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    // Tidak perlu mendefinisikan primaryKey karena defaultnya adalah 'id'
    protected $table = 'kelurahans';
    protected $primaryKey = 'id';

    public function perpustakaan()
    {
        return $this->hasMany(Perpustakaan::class, 'id_kelurahan');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_kelurahan');
    }
}
