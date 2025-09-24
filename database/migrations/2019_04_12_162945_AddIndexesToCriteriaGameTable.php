<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexesToCriteriaGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('criteria_game', function(Blueprint $table)
        {
            $table->index('criteria_id');
            $table->index('game_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('criteria_game', function (Blueprint $table)
        {
            $table->dropIndex(['criteria_id']);
            $table->dropIndex(['game_id']);
        });
    }
}
