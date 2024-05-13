<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AquariumData extends Model
{
    use HasFactory;

    public function aquarium()
    {
        return $this->hasOne(Aquarium::class);
    }
}
