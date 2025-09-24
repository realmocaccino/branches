<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('url', 65535);
			$table->text('email', 65535);
			$table->text('name', 65535);
			$table->text('description');
			$table->text('analytics');
			$table->char('robots', 1)->nullable();
			$table->char('advertisements', 1)->nullable();
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
		Schema::drop('data');
	}

}
