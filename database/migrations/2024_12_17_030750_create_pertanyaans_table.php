<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePertanyaansTable extends Migration
{
    public function up()
    {
        Schema::create('pertanyaans', function (Blueprint $table) {
            $table->id('id_pertanyaan');
            $table->text('teks_pertanyaan');
            $table->string('kategori');
            $table->year('tahun');
            $table->enum('tipe_jawaban', ['text', 'number', 'radio']); // Tambahkan tipe jawaban
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pertanyaans');
    }
}
