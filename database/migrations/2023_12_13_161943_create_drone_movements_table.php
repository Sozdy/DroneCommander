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
        Schema::create('drone_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drone_id')
                ->constrained('drones')
                ->onDelete('cascade');

            $table->string('position')->comment('The position of the square where the drone was located. In XxY format. Example: 0x0');
            $table->string('command')->comment('The command that was sent to the drone in XxY format. Example: 1x0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drone_movements');
    }
};
