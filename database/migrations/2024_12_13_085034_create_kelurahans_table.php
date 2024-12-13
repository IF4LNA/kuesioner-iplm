<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelurahansTable extends Migration
{
    public function up()
    {
        Schema::create('kelurahans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelurahan');
            $table->unsignedBigInteger('id_kecamatan');
            $table->timestamps();

            $table->foreign('id_kecamatan')->references('id')->on('kecamatans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelurahans');
    }
}
