<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdvertisementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('advertisements', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->char('status', 1)->nullable();
			$table->string('slug');
			$table->text('name', 65535);
			$table->integer('advertiser_id');
			$table->text('analytics');
			$table->char('platform', 7);
			$table->char('responsive', 1)->nullable();
			$table->text('width', 65535);
			$table->text('height', 65535);
			$table->text('style', 65535)->nullable();
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
		Schema::drop('advertisements');
	}

}
