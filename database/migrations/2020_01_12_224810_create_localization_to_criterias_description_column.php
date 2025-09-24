<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalizationToCriteriasDescriptionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('criterias', function (Blueprint $table) {
            $table->renameColumn('description', 'description_pt');
		});
		Schema::table('criterias', function (Blueprint $table) {
        	$table->string('description_en')->after('description_pt');
        	$table->string('description_es')->after('description_en');
        	$table->string('description_fr')->after('description_es');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('criterias', function (Blueprint $table) {
            $table->renameColumn('description_pt', 'description');
        	$table->dropColumn('description_en');
        	$table->dropColumn('description_es');
        	$table->dropColumn('description_fr');
		});
    }
}
