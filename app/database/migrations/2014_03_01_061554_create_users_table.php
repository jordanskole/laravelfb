<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('password');
			$table->boolean('force_password_change')->default(false);
			$table->string('photo')->nullable();
			$table->boolean('admin')->default(false); 
			$table->string('first_name')->nullable();;
			$table->string('last_name')->nullable();;
			$table->string('street')->nullable();;
			$table->string('street_2')->nullable();;
			$table->string('city')->nullable();;
			$table->string('state')->nullable();;
			$table->integer('zip')->nullable();;
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
