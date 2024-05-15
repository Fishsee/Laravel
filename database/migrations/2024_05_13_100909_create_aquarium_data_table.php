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
            $table->timestamps();
            $table->json('json_data'); // Column to store JSON data
        });

        // Your JSON data
        $jsonData = [
            'PH-Waarde' => '7',
            'Troebelheid' => '50',
            'Stroming' => '40',
            'Waterlevel' => '80',

        ];

        // Insert JSON data into the table
        \DB::table('aquarium_data')->insert([
            'json_data' => json_encode($jsonData, JSON_UNESCAPED_UNICODE)
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aquarium_data');
    }
};

