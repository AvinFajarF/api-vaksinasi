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
        Schema::create('societies', function (Blueprint $table) {
            $table->id();


            $table->integer("id_card_number");
            $table->date("born_date");
            $table->enum("gender", ["male", "female"]);
            $table->text("address");

            $table->unsignedBigInteger("regional_id");
            $table->foreign("regional_id")->references("id")->on("regionals");
            $table->string("login_token");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societies');
    }
};
