<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabansTable extends Migration
{
    public function up()
    {
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id('id_jawaban'); // Primary key
            $table->foreignId('id_pertanyaan')
                  ->constrained('pertanyaans', 'id_pertanyaan') // Menentukan kolom primary key secara eksplisit
                  ->onDelete('cascade'); // Tambahkan jika ingin delete cascade
            $table->foreignId('id_perpustakaan')
                  ->constrained('perpustakaans', 'id_perpustakaan') // Sesuaikan jika ada kolom primary key lain
                  ->onDelete('cascade');
            $table->text('jawaban');
            $table->year('tahun');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jawabans');
    }
}
