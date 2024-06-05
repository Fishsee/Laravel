<?php

// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aquarium;
use App\Models\AquariumData;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create some users
        $users = User::factory(10)->create();

        // For each user, create some aquariums and their data
        foreach ($users as $user) {
            $aquariums = Aquarium::factory(2)->create(['user_id' => $user->id]);

            foreach ($aquariums as $aquarium) {
                AquariumData::factory()->count(5)->create(['aquarium_id' => $aquarium->id]);
            }
        }
    }
}
