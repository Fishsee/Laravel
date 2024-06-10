<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AquariumData extends Model
{
    use HasFactory;

    protected $fillable = [
        'tempC',
        'distance_cm',
        'light_level',
        'water_level',
        'flow_rate',
        'phValue',
        'turbidity',
        'aquarium_id' // Add aquarium_id to fillable fields
    ];

    public function aquarium()
    {
        return $this->belongsTo(Aquarium::class);
    }
}
