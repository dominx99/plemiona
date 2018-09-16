<?php

namespace App\Repositories;

use App\Models\Army;
use App\Models\Building;
use App\Models\Timing;
use App\Models\Village;
use Carbon\Carbon;

class TimingRepository extends AbstractRepository
{
    /**
     * @param \App\Models\Village $village
     * @return integer
     */
    public function getActiveBuildingsCount(Village $village): int
    {
        return $village->buildingTimings()->where('timings.active', 1)->count();
    }

    /**
     * @param \App\Models\Village $village
     * @return integer
     */
    public function getAllBuildingsCount(Village $village): int
    {
        return $village->buildingTimings->count();
    }

    /**
     * @param \App\Models\Village $village
     * @return integer
     */
    public function getActiveArmiesCount(Village $village): int
    {
        return $village->armyTimings()->where('timings.active', 1)->count();
    }

    /**
     * @param \App\Models\Village $village
     * @return integer
     */
    public function getAllArmiesCount(Village $village): int
    {
        return $village->armyTimings->count();
    }

    /**
     * @param Village $village
     * @param Building $building
     * @return \App\Models\Timing|null
     */
    public function createBuildingIfPossible(Village $village, Building $building)
    {
        $queueCount    = $this->getAllBuildingsCount($village);
        $possibleQueue = $this->container->config->get('game.possible_queue_buildings');

        if ($possibleQueue <= $queueCount) {
            return false;
        }

        if ($village->buildingTimings()->where('timings.object_id', $building->id)->exists()) {
            return false;
        }

        if (!$village->hasEnoughGoldForBuilding($building)) {
            return false;
        }

        $village->decrement('gold', $building->cost_upgrade);

        return $village->buildingTimings()->create([
            'object_id' => $building->id,
            'type'      => 'building',
            'active'    => 0,
            'time'      => $building->time,
            'level'     => $building->pivot->building_level + 1,
        ]);
    }

    /**
     * @param \App\Models\Timing $timing
     * @return boolean
     */
    public function makeBuildingActiveIfPossible(Village $village, Timing $timing): bool
    {
        $activeCount     = $this->getActiveBuildingsCount($village);
        $possibleActives = $this->container->config->get('game.possible_active_buildings');

        if ($possibleActives <= $activeCount) {
            return false;
        }

        $building = $this->container->buildings->findByVillage($village, $timing->object_id);
        $timing->setActive($building->done_at);

        return true;
    }

    /**
     * @param \App\Models\Village $village
     * @return \App\Models\Timing
     */
    public function getLastBuildingTiming(Village $village)
    {
        return $village->buildingTimings()->orderBy('created_at')->first();
    }

    /**
     * @param \App\Models\Village $village
     * @param \App\Models\Army $army
     * @param int $amount
     * @return \App\Models\Timing|false
     */
    public function createArmyIfPossible(Village $village, Army $army, int $amount)
    {
        $queueCount    = $this->getAllArmiesCount($village);
        $possibleQueue = $this->container->config->get('game.possible_queue_armies');

        if ($possibleQueue <= $queueCount) {
            return false;
        }

        if (!$village->hasEnoughFoodForArmy($army, $amount)) {
            return false;
        }

        $village->decrement('food', ($army->cost * $amount));

        return $village->armyTimings()->create([
            'object_id' => $army->id,
            'type'      => 'army',
            'active'    => 0,
            'time'      => ($army->time * $amount),
            'amount'    => $amount,
        ]);
    }

    /**
     * @param \App\Models\Timing $timing
     * @return boolean
     */
    public function makeArmyActiveIfPossible(Village $village, Timing $timing): bool
    {
        $activeCount     = $this->getActiveArmiesCount($village);
        $possibleActives = $this->container->config->get('game.possible_active_armies');

        if ($possibleActives <= $activeCount) {
            return false;
        }

        $time = Carbon::now()->addSeconds($timing->time);

        $timing->setActive($time);

        return true;
    }

    /**
     * @param \App\Models\Village $village
     * @return \App\Models\Timing
     */
    public function getLastArmyTiming(Village $village)
    {
        return $village->armyTimings()->where('timings.active', 0)->orderBy('created_at')->first();
    }
}
