<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('promise', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('idappota');
			$table->string('fullname')->nullable();
			$table->string('phone')->nullable();
			$table->string('email')->nullable();
			$table->string('gender')->nullable();
			$table->integer('age');
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
		Schema::drop('pages');
	}

}
