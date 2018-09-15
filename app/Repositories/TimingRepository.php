<?php

namespace App\Repositories;

use App\Models\Building;
use App\Models\Timing;
use App\Models\Village;

class TimingRepository extends AbstractRepository
{
    /**
     * @return integer
     */
    public function getActiveBuildingsCount(Village $village): int
    {
        return $village->buildingTimings()->where('timings.active', 1)->count();
    }

    /**
     * @return integer
     */
    public function getAllBuildingsCount(Village $village): int
    {
        return $village->buildingTimings->count();
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

        return $village->buildingTimings()->create([
            'object_id' => $building->id,
            'type'      => 'building',
            'active'    => 0,
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

    public function getLastBuildingTiming()
    {
        return $village->buildingTimings()->orderBy('created_at', 'desc')->first();
    }
}
