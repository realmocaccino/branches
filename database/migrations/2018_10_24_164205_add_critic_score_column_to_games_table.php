<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCriticScoreColumnToGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
        	$table->decimal('critic_score', 3, 1)->nullable()->after('total_reviews');
        	$table->integer('total_critic_ratings')->nullable()->after('critic_score');
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
        	$table->dropColumn('critic_score');
        	$table->dropColumn('total_critic_ratings');
		});
    }
}
