<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('links', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('menu_id');
			$table->char('status', 1)->nullable();
			$table->text('name', 65535);
			$table->text('route', 65535);
			$table->text('parameters', 65535)->nullable();
			$table->char('target', 6);
			$table->char('order', 2)->nullable();
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
		Schema::drop('links');
	}

}
