<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKecamatansTable extends Migration
{
    public function up()
    {
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kecamatan');
            $table->unsignedBigInteger('id_kota');
            $table->timestamps();

            $table->foreign('id_kota')->references('id')->on('kotas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kecamatans');
    }
}
