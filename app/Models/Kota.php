<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'id_kota');
    }

    public function kecamatans()
{
    return $this->hasMany(Kecamatan::class, 'id_kota');
}

}
