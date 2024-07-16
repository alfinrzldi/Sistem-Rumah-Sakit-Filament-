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
        Schema::create('pasien', function (Blueprint $table) {
            // $table->id();
            $table->string('NIK')->primary();
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('telepon');
            $table->string('status');
            // $table->string('kamar_id');
            $table->timestamps();

            // $table->foreign('kamar_id')->references('no_kamar')->on('kamar');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
