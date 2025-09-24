<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeveloperGameTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('developer_game', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('developer_id')->index('developer_id');
			$table->integer('game_id')->index('game_id');
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
		Schema::drop('developer_game');
	}

}
