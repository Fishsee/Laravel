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
        Schema::create('aquarium_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aquarium_id');
            $table->timestamps();
            $table->decimal('Acidity', 5, 2);
            $table->integer('Turbidity');      // Column for turbidity
            $table->integer('Flow');         // Column for flow
            $table->integer('Waterlevel');       // Column for water level
            $table->foreign('aquarium_id')->references('id')->on('aquaria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aquarium_data');
    }
};