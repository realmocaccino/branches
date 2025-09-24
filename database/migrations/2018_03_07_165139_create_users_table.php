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
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('platform_id');
			$table->char('status', 1);
			$table->text('name', 65535);
			$table->string('email', 64);
			$table->char('newsletter', 1)->default(1);
			$table->string('password', 60);
			$table->string('token', 40)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->text('picture', 65535);
			$table->string('bio', 100)->nullable();
			$table->text('steam')->nullable();
			$table->text('psn')->nullable();
			$table->text('live')->nullable();
			$table->text('nnid')->nullable();
			$table->string('ip', 45)->nullable();
			$table->dateTime('last_access');
			$table->timestamps();
			$table->softDeletes();
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
