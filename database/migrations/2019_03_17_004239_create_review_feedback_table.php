<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewFeedbackTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reviews_feedbacks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('review_id')->index('review_id');
			$table->integer('user_id')->index('user_id');
			$table->char('feedback', 1);
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
		Schema::drop('reviews_feedbacks');
	}

}
