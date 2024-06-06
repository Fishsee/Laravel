<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAciditiesTable extends Migration
{
    public function up()
    {
        Schema::create('acidities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aquarium_id')->constrained('aquaria')->onDelete('cascade');
            $table->decimal('value', 4, 2); // assuming acidity value is a decimal
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('acidities');
    }
}

