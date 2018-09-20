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

    public function expeditions()
    {
        return $this->hasMany(Expedition::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class)->orderBy('created_at', 'desc');
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
            $level = $this->getBuildingLevelById($requirement->building_id);

            if ($level < $requirement->level) {
                return false;
            }
        }

        return true;
    }

    public function armyCopeRequirements(Army $army): bool
    {
        foreach ($army->requirements as $requirement) {
            $level = $this->getBuildingLevelById($requirement->building_id);

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

    /**
     * @param array $armies
     * @return boolean
     */
    public function hasEnoughArmies(array $armies): bool
    {
        foreach ($armies as $key => $army) {
            if (!$this->hasEnoughArmy($key, $army)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param integer $key
     * @param integer $amount
     * @return boolean
     */
    public function hasEnoughArmy(int $key, int $amount): bool
    {
        $army = $this->armies()->find($key);

        return $army->pivot->amount >= $amount;
    }

    /**
     * @param integer $capacity
     * @return array
     */
    public function decreaseResourcesOnCapacity(int $capacity): array
    {
        $food = $capacity * 1 / 3;
        $gold = $capacity * 2 / 3;

        if ($this->food < $food) {
            $food = $this->food;
        }

        if ($this->gold < $gold) {
            $gold = $this->gold;
        }

        $this->decrement('food', $food);
        $this->decrement('gold', $gold);

        return [
            'food' => $food,
            'gold' => $gold,
        ];
    }

    public function decreaseArmy(int $power): void
    {
        foreach ($this->armies()->orderBy('armies.power', 'desc')->get() as $army) {
            $defense = $army->defense * $army->pivot->amount;
            $diff    = $defense - $power;

            if ($defense <= 0) {
                continue;
            }

            if ($diff > 0) {
                $amount = $diff / $army->defense;
                $army->pivot->update(['amount' => $amount]);
            } else if ($diff == 0) {
                $army->pivot->update(['amount' => 0]);
            } else {
                $power = abs($diff);
                $army->pivot->update(['amount' => 0]);
            }
        }
    }

    /**
     * @param \App\Models\Army $army
     * @return void
     */
    public function addArmies(expedition $expedition): void
    {
        foreach ($expedition->armies as $army) {
            $villageArmy = $this->armies()->where('type', $army->type)->first();

            $villageArmy->pivot->update([
                'amount' => $villageArmy->pivot->amount + $army->pivot->amount,
            ]);
        }
    }

    public function takeArmies(array $armies): void
    {
        foreach ($armies as $key => $amount) {
            $army = $this->armies()->find($key);

            $army->pivot->update([
                'amount' => $army->pivot->amount - $amount,
            ]);
        }
    }

    public function sendAnyArmy($armies)
    {
        foreach ($armies as $army) {
            if ($army > 0) {
                return true;
            }
        }

        return false;
    }
}
