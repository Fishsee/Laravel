<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aquarium extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'pump_state'];

    protected $casts = [
        'pump_state' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aquariumData()
    {
        return $this->hasOne(AquariumData::class);
    }
}
