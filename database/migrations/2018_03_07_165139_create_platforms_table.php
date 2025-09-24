<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlatformsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('platforms', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('generation_id');
			$table->integer('manufacturer_id');
			$table->char('status', 1)->nullable();
			$table->string('slug');
			$table->text('name', 65535);
			$table->char('initials', 4);
			$table->char('release', 4);
			$table->string('logo', 64);
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
		Schema::drop('platforms');
	}

}
