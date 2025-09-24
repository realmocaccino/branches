<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('criterias', function (Blueprint $table) {
            $table->string('alternative_name_pt')->after('name_fr');
            $table->string('alternative_name_en')->after('alternative_name_pt');
            $table->string('alternative_name_es')->after('alternative_name_en');
            $table->string('alternative_name_fr')->after('alternative_name_es');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('criterias', function (Blueprint $table) {
            $table->dropColumn('alternative_name_pt');
            $table->dropColumn('alternative_name_en');
        	$table->dropColumn('alternative_name_es');
        	$table->dropColumn('alternative_name_fr');
        });
    }
};
