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
        Schema::create('jadwal_dokter', function (Blueprint $table) {
            $table->id();// Match the data type of NIPK
            $table->string('jam');
            $table->string('hari');
            $table->timestamps();
            $table->string('dokter_id');

            // Add foreign key constraint
            $table->foreign('dokter_id')->references('NIPK')->on('dokter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_dokter');
    }
};
