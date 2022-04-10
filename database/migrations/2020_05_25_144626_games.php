<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Games extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('games', function(Blueprint $table)
        {
            $table->bigIncrements('id');
           
            $table->string('thumbnail');
            $table->string('thumbnail_lg')->nullable();
            $table->string('icon')->nullable();
            $table->integer('total_play');
            $table->string('link')->nullable();;
            $table->string('game_id');
            $table->string('gma_id')->nullable();
            $table->string('api_key')->nullable();
            $table->string('fb_page_id')->nullable();
            $table->string('qr_code')->nullable();
            $table->integer('game_id');
            $table->boolean('status')->default(0)->comment('0-inactive, 1-active');
            
          
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
        Schema::dropIfExists('games');
    }
}