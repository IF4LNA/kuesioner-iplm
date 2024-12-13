<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('perpustakaans', function (Blueprint $table) {
            $table->id('id_perpustakaan'); // Primary key
            $table->string('nama_perpustakaan');
            $table->string('npp')->nullable();
            $table->enum('jenis', ['umum', 'sd', 'smp', 'mts', 'sma', 'smk', 'ma', 'khusus', 'perguruan_tinggi']);
            $table->unsignedBigInteger('id_kelurahan')->nullable()->default(null); // Foreign key ke kelurahans
            $table->string('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('id_akun'); // Foreign key ke users
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_kelurahan')->references('id')->on('kelurahans')->onDelete('cascade');
            $table->foreign('id_akun')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perpustakaans');
    }
};
