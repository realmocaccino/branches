<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarnMeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warn_me', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('game_id')->index('game_id');
			$table->integer('user_id')->index('user_id');
			$table->char('sent', 1)->nullable();
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
        Schema::drop('warn_me');
    }
}
