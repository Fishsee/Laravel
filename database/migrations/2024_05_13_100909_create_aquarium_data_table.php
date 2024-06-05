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
            $table->foreignId('aquarium_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->decimal('tempC', 8, 2);
            $table->integer('distance_cm');
            $table->integer('light_level');
            $table->integer('water_level');
            $table->integer('flow_rate');
            $table->decimal('phValue', 8, 2);
            $table->integer('turbidity');
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
