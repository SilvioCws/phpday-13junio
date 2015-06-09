<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStores extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stores', function(Blueprint $table){
			$table->increments('id');
			$table->string('email');
			$table->string('title');
			$table->text('description')->nullable()->default(null);
			$table->string('public');
			$table->string('secret');
			$table->timestamp('featured_until');
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
	}

}
