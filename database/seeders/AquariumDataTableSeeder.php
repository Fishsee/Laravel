<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AquariumData;
use App\Models\Aquarium;
use Carbon\Carbon;

class AquariumDataTableSeeder extends Seeder
{
    public function run()
    {
        // Get all aquariums
        $aquariums = Aquarium::all();

        // Loop through each aquarium and seed current data
        foreach ($aquariums as $aquarium) {
            AquariumData::create([
                'aquarium_id' => $aquarium->id,
                'acidity' => rand(0, 100) / 10,
                'turbidity' => rand(0, 100),
                'flow' => rand(0, 100),
                'waterlevel' => rand(0, 100),
            ]);

            // Seed past data (e.g., last 30 days)
            for ($i = 0; $i < 30; $i++) {
                $timestamp = Carbon::now()->subDays($i); // Generate past timestamps

                AquariumData::create([
                    'aquarium_id' => $aquarium->id,
                    'acidity' => rand(0, 100) / 10,
                    'turbidity' => rand(0, 100),
                    'flow' => rand(0, 100),
                    'waterlevel' => rand(0, 100),
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }
        }
    }
}
