<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInstitutionalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('institutionals', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->char('status', 1)->nullable();
			$table->text('slug', 65535);
			$table->text('title', 65535);
			$table->text('description');
			$table->text('text');
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
		Schema::drop('institutionals');
	}

}
