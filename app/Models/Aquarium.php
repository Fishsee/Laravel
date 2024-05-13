<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aquarium extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function data()
    {
        return $this->belongsTo(AquariumData::class);
    }

    public function fishes()
    {
        return $this->hasMany(Fish::class);
    }
}
