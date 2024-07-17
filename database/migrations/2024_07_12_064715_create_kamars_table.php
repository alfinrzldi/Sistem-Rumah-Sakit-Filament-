<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Livewire\on;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->string('no_kamar')->primary();// Sesuaikan dengan tipe data NIK pada tabel pasien Sesuaikan dengan tipe data id pada tabel petugas
            $table->string('harga');
            $table->boolean('status')->default(false);
            $table->string('pasien_id')->nullable()->default('Kosong');
            $table->timestamps();
            $table->foreign('pasien_id')->references('NIK')->on('pasien')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kamar', function (Blueprint $table) {
            $table->dropColumn([]);
        });
    }
};