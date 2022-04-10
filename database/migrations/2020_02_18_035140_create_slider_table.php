<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 200)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('thumbnail')->nullable();
            $table->string('link')->nullable();
            $table->string('target')->nullable();
            $table->integer('author_id')->default(-1);  
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
        Schema::drop('sliders');
    }
}
