<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AquariumData;
use App\Models\Aquarium;

class AquariumDataTableSeeder extends Seeder
{
    public function run()
    {
        // Get all aquariums
        $aquariums = Aquarium::all();

        // Loop through each aquarium and seed data
        foreach ($aquariums as $aquarium) {
            // Generate random data for each column
            $acidity = rand(0, 100) / 10; // Random acidity value between 0 and 10
            $turbidity = rand(0, 100); // Random turbidity value between 0 and 100
            $flow = rand(0, 100); // Random flow value between 0 and 100
            $waterlevel = rand(0, 100); // Random water level value between 0 and 100

            // Create a new aquarium data record
            AquariumData::create([
                'aquarium_id' => $aquarium->id,
                'acidity' => $acidity,
                'turbidity' => $turbidity,
                'flow' => $flow,
                'waterlevel' => $waterlevel,
            ]);
        }
    }
}
