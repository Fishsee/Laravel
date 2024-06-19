<?php

namespace Database\Factories;

use App\Models\Aquarium;
use App\Models\AquariumData;
use Illuminate\Database\Eloquent\Factories\Factory;

class AquariumDataFactory extends Factory
{
    protected $model = AquariumData::class;

    public function definition()
    {
        return [
            'aquarium_id' => Aquarium::factory()->create()->id,
            'tempC' => $this->faker->randomFloat(2, 18.0, 30.0),
            'distance_cm' => $this->faker->numberBetween(0, 100),
            'light_level' => $this->faker->numberBetween(0, 100),
            'water_level' => $this->faker->numberBetween(0, 100),
            'flow_rate' => $this->faker->numberBetween(0, 100),
            'phValue' => $this->faker->randomFloat(2, 6.0, 8.5),
            'turbidity' => $this->faker->numberBetween(0, 100),
        ];
    }
}
