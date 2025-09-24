<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGamePlatformTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('game_platform', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('game_id')->index('game_id');
			$table->integer('platform_id')->index('platform_id');
			$table->decimal('score', 3, 1)->nullable();
			$table->integer('total')->default('0');
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
		Schema::drop('game_platform');
	}

}
