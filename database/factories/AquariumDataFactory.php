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
            'aquarium_id' => Aquarium::factory(),
            'PH_Waarde' => $this->faker->randomFloat(2, 6.0, 8.5),
            'Troebelheid' => $this->faker->numberBetween(0, 100),
            'Stroming' => $this->faker->numberBetween(0, 100),
            'Waterlevel' => $this->faker->numberBetween(0, 100),
        ];
    }
}
