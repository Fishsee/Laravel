<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acidity extends Model
{
    use HasFactory;

    protected $fillable = ['aquarium_id', 'value'];
}
