<?php


namespace Database\Factories;

use App\Models\Aquarium;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AquariumFactory extends Factory
{
    protected $model = Aquarium::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
        ];
    }
}
