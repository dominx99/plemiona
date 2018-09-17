<?php

namespace App\Observers;

use App\Config;
use App\Models\Village;
use App\Repositories\ArmyRepository;
use App\Repositories\BuildingRepository;
use App\Services\ArmyExpeditor;
use App\Services\ArmyRecruiter;
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
     * @var \App\Repositories\ArmyRepository
     */
    protected $armyRepository;

    /**
     * @var \App\Services\ArmyRecruiter
     */
    protected $armyRecruiter;

    /**
     * @var \App\Services\ArmyExpeditor
     */
    protected $armyExpeditor;

    /**
     * @var \App\Services\GoldCalculator $gold
     */
    protected $gold;

    /**
     * @var \App\Services\FoodCalculator $food
     */
    protected $food;

    /**
     * @var \App\Config
     */
    protected $config;

    /**
     * @param \App\Services\GoldCalculator $gold
     * @param \App\Services\FoodCalculator $food
     * @param \App\Repositories\BuildingRepository $buildingRepository
     * @param \App\Services\BuildingUpgrador $buildingUpgrador
     * @param \App\Services\ArmyRecruiter $armyRecruiter
     * @param \App\Config $config
     */
    public function __construct(
        GoldCalculator $gold,
        FoodCalculator $food,
        BuildingRepository $buildingRepository,
        BuildingUpgrador $buildingUpgrador,
        ArmyRepository $armyRepository,
        ArmyRecruiter $armyRecruiter,
        ArmyExpeditor $armyExpeditor,
        Config $config
    ) {
        $this->buildingRepository = $buildingRepository;
        $this->buildingUpgrador   = $buildingUpgrador;

        $this->armyRepository = $armyRepository;
        $this->armyRecruiter  = $armyRecruiter;
        $this->armyExpeditor  = $armyExpeditor;

        $this->gold = $gold;
        $this->food = $food;

        $this->config = $config;
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
        $this->buildingUpgrador->setNewActive($village);

        $this->armyRecruiter->recruitForVillage($village);
        $this->armyRecruiter->setNewActive($village);

        $this->armyExpeditor->endExpeditions($village);
    }

    /**
     * @param \App\Models\Village $village
     * @return void
     */
    public function created(Village $village): void
    {
        foreach ($this->config->get('buildings.buildings_at_start') as $type => $building) {
            $buildingByType = $this->buildingRepository->findByType($type);

            $village->buildings()->attach($buildingByType->id, ['building_level' => $building['level']]);
        }

        foreach ($this->config->get('armies.armies_at_start') as $type) {
            $armyByType = $this->armyRepository->findByType($type);

            $village->armies()->attach($armyByType->id, ['amount' => 0]);
        }
    }
}
