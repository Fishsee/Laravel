<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aquarium;

class AquariumsTableSeeder extends Seeder
{
    public function run()
    {
        Aquarium::create([
            'user_id' => 1,
            'updated_at' => now(),
            'created_at' => now(),
        ]);
    }
}
