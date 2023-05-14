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
        Schema::create('konsultasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('masyarakat_id');

            $table->foreign('masyarakat_id')->references('id')->on('masyarakat');

            $table->unsignedBigInteger('dokter_id');

            $table->foreign('dokter_id')->references('id')->on('dokter');

          $table->string("riwayat_penyakit");

          $table->string("gejala");

          $table->text("catatan_dokter");


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasis');
    }
};
