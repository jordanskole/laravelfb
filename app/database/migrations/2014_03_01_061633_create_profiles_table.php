<?php

use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function($table) {	
			// create our provides information
			$table->increments('id');
	        $table->integer('user_id')->unsigned();
	        $table->string('username');
	        $table->biginteger('uid')->unsigned();
	        $table->string('access_token');
	        $table->string('access_token_secret')->nullable();
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
		// drop the profiles table
		Schema::drop('profiles');
	}

}