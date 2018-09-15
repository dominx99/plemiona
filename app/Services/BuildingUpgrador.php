<?php

namespace App\Services;

use App\Models\Village;
use App\Repositories\BuildingRepository;
use App\Repositories\TimingRepository;
use Carbon\Carbon;

class BuildingUpgrador
{
    /**
     * @var \App\Repositories\BuildingRepository
     */
    protected $buildings;

    /**
     * @var \App\Repositories\TimingRepository
     */
    protected $timings;

    /**
     * @param \App\Repositories\BuildingRepository $buildings
     */
    public function __construct(
        BuildingRepository $buildings,
        TimingRepository $timings
    ) {
        $this->buildings = $buildings;
        $this->timings   = $timings;
    }

    /**
     * @param \App\Models\Village $village
     * @return void
     */
    public function upgradeForVillage(Village $village)
    {
        $now = Carbon::now();

        foreach ($village->buildingTimings as $timing) {
            if (!$timing->active) {
                continue;
            }

            $buildingDoneTime = Carbon::createFromTimeString($timing->done_at);
            if ($now > $buildingDoneTime) {
                $building = $this->buildings->findByVillage($village, $timing->object_id);
                $building->increaseBuildingLevel();

                $timing->delete();
            }
        }
    }

    /**
     * @param \App\Models\Village $village
     * @return void
     */
    public function setNewActive(Village $village): void
    {
        if ($this->timings->getActiveBuildingsCount($village) === 0) {
            $timing = $this->timings->getLastBuildingTiming($village);

            $timing->setActive();
        }
    }
}
