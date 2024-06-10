<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAquariumDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aquarium_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aquarium_id')->constrained()->onDelete('cascade'); // Add foreign key constraint
            $table->decimal('tempC', 8, 2);
            $table->decimal('distance_cm', 8, 2);
            $table->decimal('light_level', 8, 2);
            $table->decimal('water_level', 8, 2);
            $table->decimal('flow_rate', 8, 2);
            $table->decimal('phValue', 8, 2);
            $table->decimal('turbidity', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aquarium_data');
    }
}
