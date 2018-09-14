<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    protected $appends = [
        'cost',
        'cost_upgrade',
        'can_upgrade',
    ];

    /** RELATIONSHIPS */

    public function costs()
    {
        return $this->hasMany(BuildingCost::class);
    }

    /** OTHERS */

    public function getCostAttribute()
    {
        return $this->costs()->where('level', $this->pivot->building_level)->first()->value;
    }

    public function getCostUpgradeAttribute()
    {
        if ($this->canUpgrade()) {
            return $this->costs()->where('level', $this->pivot->building_level + 1)->first()->value;
        }

        return null;
    }

    public function getCanUpgradeAttribute()
    {
        return $this->canUpgrade();
    }

    public function canUpgrade()
    {
        return $this->costs()->where('level', $this->pivot->building_level + 1)->exists();
    }
}
