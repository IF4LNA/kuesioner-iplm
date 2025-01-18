<?php

// app/Models/JenisPerpustakaan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPerpustakaan extends Model
{
    use HasFactory;

    protected $table = 'jenis_perpustakaans';
    protected $primaryKey = 'id_jenis'; 
    protected $fillable = ['jenis', 'subjenis'];

    // relasi dengan Perpustakaan
    public function perpustakaan()
    {
        return $this->hasMany(Perpustakaan::class, 'id_jenis', 'id_jenis');
    }
}

