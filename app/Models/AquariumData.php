<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AquariumData extends Model
{
    use HasFactory;

    protected $fillable = ['aquarium_id', 'PH_Waarde', 'Troebelheid', 'Stroming', 'Waterlevel'];

    public function aquarium()
    {
        return $this->belongsTo(Aquarium::class);
    }
}
