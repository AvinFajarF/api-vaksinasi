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
        Schema::create('consultacions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("society_id");
            $table->foreign("society_id")->references("id")->on("societies");


            $table->unsignedBigInteger("doctor_id")->nullable();
            $table->foreign("doctor_id")->references("id")->on("medical");

            $table->enum("status",["pending","accepted","rejected"]);

            $table->string("disease_history");
            $table->string("current_symptoms");
            $table->text("doctor_notes");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultacions');
    }
};
