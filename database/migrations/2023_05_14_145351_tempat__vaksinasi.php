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
       Schema::create('tempat_vaksin', function (Blueprint $table) {
        $table->id();
        $table->text("tempat");
        $table->integer("kapasitas");

        $table->unsignedBigInteger('dokter_id');

        $table->foreign('dokter_id')->references('id')->on('dokter');
        $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop("tempat_vaksin");
    }
};
