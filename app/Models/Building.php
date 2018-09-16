<?php

namespace App\Models;

use Carbon\Carbon;
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
        'time',
        'done_at',
    ];

    /** RELATIONSHIPS */

    public function costs()
    {
        return $this->hasMany(BuildingCost::class);
    }

    public function requirements()
    {
        return $this->morphMany(Requirement::class, 'requirementable')->where('requirementable_level', $this->pivot->building_level);
    }

    /** ATTRIBUTES */

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

    public function getTimeAttribute()
    {
        if ($this->canUpgrade()) {
            return $this->costs()->where('level', $this->pivot->building_level + 1)->first()->time;
        }

        return null;
    }

    public function getDoneAtAttribute()
    {
        if ($this->canUpgrade()) {
            $now  = Carbon::now();
            $time = $this->costs()->where('level', $this->pivot->building_level + 1)->first()->time;

            return $now->addSeconds($time)->format('Y-m-d H:i:s');
        }

        return null;
    }

    /** OTHERS */

    /**
     * @return void
     */
    public function increaseBuildingLevel(): void
    {
        $this->pivot->update([
            'building_level' => $this->pivot->building_level + 1,
        ]);
    }
}
