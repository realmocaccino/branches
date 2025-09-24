<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('games', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('classification_id')->nullable();
			$table->char('status', 1)->nullable();
			$table->string('slug');
			$table->text('name', 65535);
			$table->text('alias', 65535)->nullable();
			$table->text('description')->nullable();
			$table->date('release')->nullable();
			$table->string('cover', 64)->nullable();
			$table->string('background', 64)->nullable();
			$table->char('trailer', 11)->nullable();
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
		Schema::drop('games');
	}

}
