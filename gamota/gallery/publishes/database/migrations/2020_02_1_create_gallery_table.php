<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gallery', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 200)->nullable();
			$table->string('slug', 200)->nullable();
			$table->string('thumbnail')->nullable();
			$table->string('youtube_id', 50)->nullable();
			$table->tinyInteger('status')->default(0);
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
		Schema::drop('gallery');
	}

}
