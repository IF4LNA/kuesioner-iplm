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
        'nama_perpustakaan', 'npp', 'nama_pengelola','id_jenis', 'id_kelurahan', 'alamat', 'kontak', 'foto', 'id_akun'
    ];

    // Relasi dengan tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_akun');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisPerpustakaan::class, 'id_jenis');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }

    public function kecamatan()
{
    return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
}

public function kota()
{
    return $this->belongsTo(Kota::class, 'id_kota');
}


    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'id_perpustakaan', 'id_perpustakaan');
    }
    

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_perpustakaan');
    }
}
