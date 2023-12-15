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
        Schema::table('drone_movements', function (Blueprint $table) {
            $table->renameColumn('position', 'start_position');
            $table->string('current_position')->after('command');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drone_movements', function (Blueprint $table) {
            $table->renameColumn('start_position', 'position');
            $table->dropColumn('current_position');
        });
    }
};
