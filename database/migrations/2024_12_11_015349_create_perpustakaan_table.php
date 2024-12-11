<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('perpustakaans', function (Blueprint $table) {
            $table->id('id_perpustakaan');
            $table->string('nama_perpustakaan');
            $table->string('npp')->nullable();
            $table->enum('jenis', ['umum', 'sd', 'smp', 'mts', 'sma', 'smk', 'ma', 'khusus', 'perguruan_tinggi']);
            $table->unsignedBigInteger('id_kelurahan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('id_akun')->nullable();
            $table->timestamps();
        
            $table->foreign('id_akun')->references('id')->on('users')->onDelete('cascade');
        });  
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perpustakaan');
    }
};
