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
        Schema::create('diagnosa', function (Blueprint $table) {
            $table->string('rekam_medis')->primary(); // Menggunakan rekam_medis sebagai primary key
            $table->string('harga');
            $table->timestamps();
            $table->string('dokter_id');
            $table->string('pasien_id');
            $table->string('kamar_id');

            // Add foreign key constraints
            $table->foreign('pasien_id')->references('NIK')->on('pasien');
            $table->foreign('kamar_id')->references('no_kamar')->on('kamar');
            $table->foreign('dokter_id')->references('NIPK')->on('dokter');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosa');
    }
};
