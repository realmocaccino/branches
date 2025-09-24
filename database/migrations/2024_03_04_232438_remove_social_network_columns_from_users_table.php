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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('steam');
            $table->dropColumn('psn');
            $table->dropColumn('live');
            $table->dropColumn('nnid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('steam')->nullable();
			$table->text('psn')->nullable();
			$table->text('live')->nullable();
			$table->text('nnid')->nullable();
        });
    }
};
