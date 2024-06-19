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
        Schema::create('fish_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fish_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('ph_min', 8, 2);
            $table->decimal('ph_max', 8, 2);
            $table->decimal('lightlevel_min', 8, 2);
            $table->decimal('lightlevel_max', 8, 2);
            $table->decimal('temperature_min', 8, 2);
            $table->decimal('temperature_max', 8, 2);
            $table->decimal('waterlevel_min', 8, 2);
            $table->decimal('waterlevel_max', 8, 2);
            $table->decimal('flowrate_min', 8, 2);
            $table->decimal('flowrate_max', 8, 2);
            $table->decimal('turbidity_min', 8, 2);
            $table->decimal('turbidity_max', 8, 2);
            $table->timestamps();
            $table->foreign('fish_id')->references('id')->on('fish')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fish_types');
    }
};
