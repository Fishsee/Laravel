<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Acidity;
use Carbon\Carbon;

class AciditiesTableSeeder extends Seeder
{
    public function run()
    {
        $aquariumId = 1; // Assuming aquarium_id 1 exists
        for ($i = 0; $i < 12; $i++) {
            Acidity::create([
                'aquarium_id' => $aquariumId,
                'value' => 7.0 + (rand(-10, 10) / 100),
                'created_at' => Carbon::now()->subHours($i),
            ]);
        }
    }
}
