<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildingCost extends Model
{
    protected $fillable = [
        'building_id',
        'level',
        'value',
    ];
}
