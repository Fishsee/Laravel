<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveData extends Model
{
    protected $fillable = ['tempC', 'distance_cm', 'light_level', 'water_level', 'flow_rate', 'phValue', 'turbidity'];
}
