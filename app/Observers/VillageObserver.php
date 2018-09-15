<?php

namespace App\Observers;

use App\Config;
use App\Models\Village;
use App\Repositories\BuildingRepository;
use App\Services\BuildingUpgrador;
use App\Services\FoodCalculator;
use App\Services\GoldCalculator;
use Carbon\Carbon;

class VillageObserver
{
    /**
     * @var \App\Repositories\BuildingRepository
     */
    protected $buildingRepository;

    /**
     * @var \App\Services\BuildingUpgrador
     */
    protected $buildingUpgrador;

    /**
     * @var \App\Services\GoldCalculator $gold
     */
    protected $gold;

    /**
     * @var \App\Services\FoodCalculator $food
     */
    protected $food;

    /**
     * @var array
     */
    protected $buildings;

    /**
     * @param \App\Services\GoldCalculator $gold
     * @param \App\Services\FoodCalculator $food
     */
    public function __construct(
        GoldCalculator $gold,
        FoodCalculator $food,
        BuildingRepository $buildingRepository,
        BuildingUpgrador $buildingUpgrador,
        Config $config
    ) {
        $this->buildingRepository = $buildingRepository;
        $this->buildingUpgrador   = $buildingUpgrador;

        $this->gold = $gold;
        $this->food = $food;

        $this->buildings = $config->get('buildings.buildings_at_start');
    }

    /**
     * @param \App\Models\Village $village
     * @return void
     */
    public function retrieved(Village $village): void
    {
        $goldPerSec = $this->gold->calculate($village);
        $foodPerSec = $this->food->calculate($village);

        $now        = Carbon::now();
        $lastActive = Carbon::createFromTimeString($village->updated_at);

        $diff = $now->diffInSeconds($lastActive);

        $gold = $goldPerSec * $diff;
        $food = $foodPerSec * $diff;

        $village->increment('gold', $gold);
        $village->increment('food', $food);

        $this->buildingUpgrador->upgradeForVillage($village);
        // $this->buildingUpgrador->setNewActive($village);
    }

    /**
     * @param \App\Models\Village $village
     * @return void
     */
    public function created(Village $village): void
    {
        foreach ($this->buildings as $type => $building) {
            $buildingByType = $this->buildingRepository->findByType($type);

            $village->buildings()->attach($buildingByType->id, ['building_level' => $building['level']]);
        }
    }
}
