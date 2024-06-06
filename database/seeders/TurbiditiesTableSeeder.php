<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turbidity;
use Carbon\Carbon;

class TurbiditiesTableSeeder extends Seeder
{
    public function run()
    {
        $aquariumId = 1; // Assuming aquarium_id 1 exists
        for ($i = 0; $i < 12; $i++) {
            Turbidity::create([
                'aquarium_id' => $aquariumId,
                'value' => 30 + ($i * 5), // Increasing value for demonstration
                'created_at' => Carbon::now()->subHours($i),
            ]);
        }
    }
}
