<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FishType extends Model
{
    use HasFactory;

    // Explicitly define the table associated with the model
    protected $table = 'fish_types';

    // The primary key is not strictly necessary to define if you are using 'id'
    protected $primaryKey = 'id';

    // Assuming you want to allow mass assignment for all fields except the id
    protected $guarded = ['id'];

    // Define relationship with the Fish model
    public function fish()
    {
        return $this->belongsTo(Fish::class, 'fish_id');
    }
}
