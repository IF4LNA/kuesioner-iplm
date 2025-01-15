<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporansTable extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id('id_laporan'); // Primary key
            $table->foreignId('id_perpustakaan')->constrained('perpustakaans', 'id_perpustakaan')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->constrained('kelurahans', 'id')->onDelete('cascade');
            $table->foreignId('id_pertanyaan')->constrained('pertanyaans', 'id_pertanyaan')->onDelete('cascade');
            $table->foreignId('id_jawaban')->constrained('jawabans', 'id_jawaban')->onDelete('cascade');
            $table->foreignId('id_akun')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporans');
    }
}
