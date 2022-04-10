<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GameToCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_to_category', function(Blueprint $table)
        {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('game_category')->onDelete('cascade');

            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');

            // $table->unsignedBigInteger('game_id');
            // $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('game_to_category');
    }
}