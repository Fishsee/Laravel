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
        Schema::create('live_data', function (Blueprint $table) {
            $table->id();
            $table->decimal('tempC');
            $table->integer('distance_cm');
            $table->integer('light_level');
            $table->integer('water_level');
            $table->integer('flow_rate');
            $table->decimal('phValue');
            $table->integer('turbidity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_data');
    }
};
