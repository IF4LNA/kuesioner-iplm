<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ActivityLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'action', 
        'description', 
        'created_at', 
        'id_akun'
    ];

    // Menambahkan kolom waktu ke array dates untuk memastikan Eloquent menggunakan Carbon
    protected $dates = ['created_at'];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_akun');
    }
}
