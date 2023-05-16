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
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();

            $table->integer("dose");
            $table->date("date");

            $table->unsignedBigInteger("society_id");
            $table->foreign("society_id")->references("id")->on("societies");

            $table->unsignedBigInteger("spot_id");
            $table->foreign("spot_id")->references("id")->on("spots");

            $table->unsignedBigInteger("vaccine_id");
            $table->foreign("vaccine_id")->references("id")->on("vaccines");

            $table->unsignedBigInteger("medical_id");
            $table->foreign("medical_id")->references("id")->on("medical");



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};
