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
        Schema::create('jenis_perpustakaans', function (Blueprint $table) {
            $table->id('id_jenis');
            $table->string('jenis'); // Jenis utama (Umum, Sekolah, Perguruan Tinggi, Khusus)
            $table->string('subjenis')->nullable(); // Subjenis (Kab/Kota, Kecamatan, dst.) nullable untuk jenis tanpa subjenis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_perpustakaans');
    }
};
