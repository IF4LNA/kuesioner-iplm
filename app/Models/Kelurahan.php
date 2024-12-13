<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;
    protected $table = 'kelurahans';
    protected $primaryKey = 'id_kelurahan';

    public function perpustakaans()
    {
        return $this->hasMany(Perpustakaan::class, 'id_kelurahan');
    }

}
