<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email', 320);
			$table->string('facebookToken', 64)->nullable();
			$table->boolean('facebookActivation')->nullable();
			$table->string('instagramToken', 64)->nullable();
			$table->boolean('instagramActivation')->nullable();
			$table->string('twitterToken', 64)->nullable();
			$table->string('twitterSecret', 64)->nullable();
			$table->boolean('twitterActivation')->nullable();
			$table->string('snapchatUsername', 64)->nullable();
			$table->string('snapchatPassword', 64)->nullable();
			$table->boolean('snapchatActivation')->nullable();
			$table->boolean('phoneActivation')->nullable();
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
		Schema::drop('users');
	}

}
