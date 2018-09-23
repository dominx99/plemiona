<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $fillable = [
        'requirementable_id',
        'requirementable_type',
        'requirementable_level',
        'level',
        'building_id',
    ];

    public function requirementable()
    {
        return $this->morphTo();
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function buildingCost()
    {
        return $this->hasOne(BuildingCost::class, ['building_id', 'level'], ['building_id', 'level']);
    }
}
