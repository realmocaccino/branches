<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAfilliateCollumnsToGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
        	$table->string('affiliate_link')->nullable()->after('total_critic_ratings');
        	$table->text('affiliate_iframe')->nullable()->after('affiliate_link');
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
        	$table->dropColumn('affiliate_link');
        	$table->dropColumn('affiliate_iframe');
		});
    }
}
