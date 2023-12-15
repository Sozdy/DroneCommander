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
            $table->dropForeign(['drone_id']);
            $table->dropColumn('drone_id');
        });

        Schema::dropIfExists('drones');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('drones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('drones')->insert([
            'name' => 'Drone 1',
        ]);

        Schema::table('drone_movements', function (Blueprint $table) {
            $table->foreignId('drone_id')
                ->constrained('drones')
                ->onDelete('cascade');
        });

    }
};
