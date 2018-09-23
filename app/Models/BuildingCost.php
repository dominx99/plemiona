<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildingCost extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $fillable = [
        'building_id',
        'level',
        'value',
        'time',
    ];
}
