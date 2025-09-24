<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCollectionGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collection_game', function (Blueprint $table) {
        	$table->renameColumn('list_id', 'collection_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('collection_game', function (Blueprint $table) {
		    $table->renameColumn('collection_id', 'list_id');
		});
    }
}
