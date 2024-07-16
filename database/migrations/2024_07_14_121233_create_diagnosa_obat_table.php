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
        Schema::create('diagnosa_obat', function (Blueprint $table) {
            $table->string('rekam_medis'); // Menggunakan rekam_medis sebagai foreign key
            $table->string('kode_obat'); // Menggunakan kode_obat sebagai foreign key

            // Primary key dan foreign key constraints
            $table->primary(['rekam_medis', 'kode_obat']);
            $table->foreign('rekam_medis')->references('rekam_medis')->on('diagnosa');
            $table->foreign('kode_obat')->references('kode_obat')->on('obat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosa_obat');
    }
};
