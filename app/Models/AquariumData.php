<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AquariumData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'tempC',
        'distance_cm',
        'light_level',
        'water_level',
        'flow_rate',
        'phValue',
        'turbidity',
        'aquarium_id',
        'ip'
    ];

    public function aquarium()
    {
        return $this->belongsTo(Aquarium::class);
    }
}
