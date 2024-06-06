<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurbiditiesTable extends Migration
{
    public function up()
    {
        Schema::create('turbidities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aquarium_id')->constrained('aquaria')->onDelete('cascade');
            $table->decimal('value', 5, 2); // assuming turbidity value is a decimal
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('turbidities');
    }
}
