<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGamesTableForStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('games', function (Blueprint $table) {
			$table->decimal('score', 3, 1)->nullable()->after('trailer');
			$table->integer('total_ratings')->default('0')->after('score');
			$table->integer('total_reviews')->default('0')->after('total_ratings');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('games', function (Blueprint $table) {
    		$table->dropColumn('total_ratings');
			$table->dropColumn('total_reviews');
		});
    }
}
