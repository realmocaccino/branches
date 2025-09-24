<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalizationInDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->renameColumn('title', 'title_pt');
            $table->renameColumn('description', 'description_pt');
		});
		Schema::table('contacts', function (Blueprint $table) {
        	$table->string('title_en')->after('title_pt');
        	$table->string('title_es')->after('title_en');
        	$table->string('title_fr')->after('title_es');
        	$table->text('description_en')->after('description_pt');
        	$table->text('description_es')->after('description_en');
        	$table->text('description_fr')->after('description_es');
		});
        Schema::table('criterias', function (Blueprint $table) {
            $table->renameColumn('name', 'name_pt');
		});
		Schema::table('criterias', function (Blueprint $table) {
        	$table->string('name_en')->after('name_pt');
        	$table->string('name_es')->after('name_en');
        	$table->string('name_fr')->after('name_es');
		});
        Schema::table('characteristics', function (Blueprint $table) {
            $table->renameColumn('name', 'name_pt');
		});
		Schema::table('characteristics', function (Blueprint $table) {
        	$table->string('name_en')->after('name_pt');
        	$table->string('name_es')->after('name_en');
        	$table->string('name_fr')->after('name_es');
		});
		Schema::table('genres', function (Blueprint $table) {
		    $table->renameColumn('name', 'name_pt');
		});
		Schema::table('genres', function (Blueprint $table) {
        	$table->string('name_en')->after('name_pt');
        	$table->string('name_es')->after('name_en');
        	$table->string('name_fr')->after('name_es');
		});
		Schema::table('institutionals', function (Blueprint $table) {
            $table->renameColumn('title', 'title_pt');
            $table->renameColumn('description', 'description_pt');
            $table->renameColumn('text', 'text_pt');
		});
		Schema::table('institutionals', function (Blueprint $table) {
        	$table->string('title_en')->after('title_pt');
        	$table->string('title_es')->after('title_en');
        	$table->string('title_fr')->after('title_es');
        	$table->text('description_en')->after('description_pt');
        	$table->text('description_es')->after('description_en');
        	$table->text('description_fr')->after('description_es');
        	$table->text('text_en')->after('text_pt');
        	$table->text('text_es')->after('text_en');
        	$table->text('text_fr')->after('text_es');
		});
		Schema::table('links', function (Blueprint $table) {
		    $table->renameColumn('name', 'name_pt');
		});
		Schema::table('links', function (Blueprint $table) {
        	$table->string('name_en')->after('name_pt');
        	$table->string('name_es')->after('name_en');
        	$table->string('name_fr')->after('name_es');
		});
		Schema::table('modes', function (Blueprint $table) {
		    $table->renameColumn('name', 'name_pt');
		});
		Schema::table('modes', function (Blueprint $table) {
        	$table->string('name_en')->after('name_pt');
        	$table->string('name_es')->after('name_en');
        	$table->string('name_fr')->after('name_es');
		});
		Schema::table('settings', function (Blueprint $table) {
		    $table->renameColumn('description', 'description_pt');
		});
		Schema::table('settings', function (Blueprint $table) {
        	$table->string('description_en')->after('description_pt');
        	$table->string('description_es')->after('description_en');
        	$table->string('description_fr')->after('description_es');
		});
		Schema::table('themes', function (Blueprint $table) {
		    $table->renameColumn('name', 'name_pt');
		});
		Schema::table('themes', function (Blueprint $table) {
        	$table->string('name_en')->after('name_pt');
        	$table->string('name_es')->after('name_en');
        	$table->string('name_fr')->after('name_es');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->renameColumn('title_pt', 'title');
        	$table->dropColumn('title_en');
        	$table->dropColumn('title_es');
        	$table->dropColumn('title_fr');
        	$table->renameColumn('description_pt', 'description');
        	$table->dropColumn('description_en');
        	$table->dropColumn('description_es');
        	$table->dropColumn('description_fr');
		});
        Schema::table('criterias', function (Blueprint $table) {
            $table->renameColumn('name_pt', 'name');
        	$table->dropColumn('name_en');
        	$table->dropColumn('name_es');
        	$table->dropColumn('name_fr');
		});
		Schema::table('characteristics', function (Blueprint $table) {
		    $table->renameColumn('name_pt', 'name');
        	$table->dropColumn('name_en');
        	$table->dropColumn('name_es');
        	$table->dropColumn('name_fr');
		});
		Schema::table('genres', function (Blueprint $table) {
		    $table->renameColumn('name_pt', 'name');
        	$table->dropColumn('name_en');
        	$table->dropColumn('name_es');
        	$table->dropColumn('name_fr');
		});
		Schema::table('institutionals', function (Blueprint $table) {
		    $table->renameColumn('title_pt', 'title');
        	$table->dropColumn('title_en');
        	$table->dropColumn('title_es');
        	$table->dropColumn('title_fr');
        	$table->renameColumn('description_pt', 'description');
        	$table->dropColumn('description_en');
        	$table->dropColumn('description_es');
        	$table->dropColumn('description_fr');
        	$table->renameColumn('text_pt', 'text');
        	$table->dropColumn('text_en');
        	$table->dropColumn('text_es');
        	$table->dropColumn('text_fr');
		});
		Schema::table('links', function (Blueprint $table) {
		    $table->renameColumn('name_pt', 'name');
        	$table->dropColumn('name_en');
        	$table->dropColumn('name_es');
        	$table->dropColumn('name_fr');
		});
		Schema::table('modes', function (Blueprint $table) {
		    $table->renameColumn('name_pt', 'name');
        	$table->dropColumn('name_en');
        	$table->dropColumn('name_es');
        	$table->dropColumn('name_fr');
		});
		Schema::table('settings', function (Blueprint $table) {
		    $table->renameColumn('description_pt', 'description');
        	$table->dropColumn('description_en');
        	$table->dropColumn('description_es');
        	$table->dropColumn('description_fr');
		});
		Schema::table('themes', function (Blueprint $table) {
		    $table->renameColumn('name_pt', 'name');
        	$table->dropColumn('name_en');
        	$table->dropColumn('name_es');
        	$table->dropColumn('name_fr');
		});
    }
}
