<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlternativeNameToGenresAndThemesAndCharacteristicsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('genres', function (Blueprint $table) {
        	$table->string('alternative_name_pt')->after('name_fr');
            $table->string('alternative_name_en')->after('alternative_name_pt');
            $table->string('alternative_name_es')->after('alternative_name_en');
            $table->string('alternative_name_fr')->after('alternative_name_es');
		});
        Schema::table('themes', function (Blueprint $table) {
        	$table->string('alternative_name_pt')->after('name_fr');
            $table->string('alternative_name_en')->after('alternative_name_pt');
            $table->string('alternative_name_es')->after('alternative_name_en');
            $table->string('alternative_name_fr')->after('alternative_name_es');
		});
        Schema::table('characteristics', function (Blueprint $table) {
        	$table->string('alternative_name_pt')->after('name_fr');
            $table->string('alternative_name_en')->after('alternative_name_pt');
            $table->string('alternative_name_es')->after('alternative_name_en');
            $table->string('alternative_name_fr')->after('alternative_name_es');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('genres', function (Blueprint $table) {
        	$table->dropColumn('alternative_name_pt');
            $table->dropColumn('alternative_name_en');
        	$table->dropColumn('alternative_name_es');
        	$table->dropColumn('alternative_name_fr');
		});
        Schema::table('themes', function (Blueprint $table) {
        	$table->dropColumn('alternative_name_pt');
            $table->dropColumn('alternative_name_en');
        	$table->dropColumn('alternative_name_es');
        	$table->dropColumn('alternative_name_fr');
		});
        Schema::table('characteristics', function (Blueprint $table) {
        	$table->dropColumn('alternative_name_pt');
            $table->dropColumn('alternative_name_en');
        	$table->dropColumn('alternative_name_es');
        	$table->dropColumn('alternative_name_fr');
		});
    }
}
