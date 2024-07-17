<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->string('diagnosa_id');
            // $table->string('pasien_id');
            // $table->string('kamar_id')->nullable();
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar');
            $table->timestamps();

            $table->foreign('diagnosa_id')->references('rekam_medis')->on('diagnosa');
            // $table->foreign('pasien_id')->references('NIK')->on('pasien');
            // $table->foreign('kamar_id')->references('no_kamar')->on('kamar');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};