<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFranchisesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('franchises', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->char('status', 1)->nullable();
			$table->string('slug');
			$table->text('name', 65535);
			$table->text('alias', 65535);
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
		Schema::drop('franchises');
	}

}
