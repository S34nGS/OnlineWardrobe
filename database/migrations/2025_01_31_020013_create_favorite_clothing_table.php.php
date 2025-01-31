<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoriteClothingTable extends Migration
{
    /**
     * De opzet van de migratie.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_clothing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relatie met users
            $table->foreignId('clothing_id')->constrained()->onDelete('cascade'); // Relatie met clothing
            $table->timestamps();
        });
    }

    /**
     * Het terugdraaien van de migratie.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorite_clothing');
    }
}
