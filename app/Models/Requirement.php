<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
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
}
