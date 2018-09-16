<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'x',
        'y',
        'gold',
        'food',
    ];

    public function buildings()
    {
        return $this->belongsToMany(Building::class)->withPivot('building_level');
    }

    public function armies()
    {
        return $this->belongsToMany(Army::class)->withPivot('amount');
    }

    public function timings()
    {
        return $this->hasMany(Timing::class);
    }

    public function buildingTimings()
    {
        return $this->timings()->where('type', 'building');
    }

    public function armyTimings()
    {
        return $this->timings()->where('type', 'army');
    }

    /**
     * @param string $building
     * @return integer
     */
    public function getBuildingLevel(string $building): int
    {
        return $this->buildings()->where('type', $building)->first()->pivot->building_level;
    }

    /**
     * @param integer $id
     * @return integer
     */
    public function getBuildingLevelById(int $id): int
    {
        return $this->buildings()->where('buildings.id', $id)->first()->pivot->building_level;
    }

    /**
     * @param integer $userId
     * @return boolean
     */
    public function isOwner(int $userId): bool
    {
        return $this->user_id === $userId;
    }

    /**
     * @param \App\Models\Building $building
     * @return void
     */
    public function upgradeBuilding(Building $building): void
    {
        $this->buildingTimings()->create([
            'object_id' => $building->id,
            'type'      => 'building',
            'done_at'   => $building->done_at,
        ]);
    }

    /**
     * @param \App\Models\Building $building
     * @return boolean
     */
    public function buildingCopeRequirements(Building $building): bool
    {
        foreach ($building->requirementsByLevel as $requirement) {
            $level = $villageBuildingLevel = $this->getBuildingLevelById($requirement->building_id);

            if ($level < $requirement->level) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param \App\Models\Building $building
     * @return boolean
     */
    public function hasEnoughGoldForBuilding(Building $building): bool
    {
        return $this->gold > $building->cost_upgrade;
    }

    /**
     * @param \App\Models\Army $army
     * @param integer $amount
     * @return boolean
     */
    public function hasEnoughFoodForArmy(Army $army, int $amount): bool
    {
        return $this->food > ($army->cost * $amount);
    }
}
