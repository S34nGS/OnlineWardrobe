<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutfitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outfits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable(); // Optional name for the outfit
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('clothing_outfit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clothing_id');
            $table->unsignedBigInteger('outfit_id');
            $table->timestamps();

            $table->foreign('clothing_id')->references('id')->on('clothing')->onDelete('cascade');
            $table->foreign('outfit_id')->references('id')->on('outfits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clothing_outfit');
        Schema::dropIfExists('outfits');
    }
}