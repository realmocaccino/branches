<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCharacteristicGameTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('characteristic_game', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('characteristic_id')->index('characteristic_id');
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
		Schema::drop('characteristic_game');
	}

}
