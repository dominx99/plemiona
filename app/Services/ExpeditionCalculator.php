<?php

namespace App\Services;

use App\Models\Expedition;
use App\Services\ArmyCalculator;
use App\Services\ResourcesCalculator;
use App\Services\RoadCalculator;

class ExpeditionCalculator
{
    /**
     * @var \App\Services\ArmyCalculator
     */
    protected $armyCalculator;

    /**
     * @var \App\Services\ResourcesCalculator
     */
    protected $resourcesCalculator;

    /**
     * @var \App\Services\RoadCalculator
     */
    protected $roadCalculator;

    /**
     * @param \App\Services\ArmyCalculator $armyCalculator
     */
    public function __construct(
        ArmyCalculator $armyCalculator,
        ResourcesCalculator $resourcesCalculator,
        RoadCalculator $roadCalculator
    ) {
        $this->armyCalculator      = $armyCalculator;
        $this->resourcesCalculator = $resourcesCalculator;
        $this->roadCalculator      = $roadCalculator;
    }

    /**
     * @param \App\Models\Expedition $expedition
     * @return void
     */
    public function calculate(Expedition $expedition): void
    {
        $type        = $expedition->type;
        $destination = $expedition->destination;

        $method = $type . ucfirst($destination);

        $this->{$method}($expedition);
    }

    /**
     * @param \App\Models\Expedition $expedition
     * @return boolean
     */
    public function attackForwards(Expedition $expedition): bool
    {
        $receiver = $expedition->receiver;
        $sender   = $expedition->sender;

        $defense = $this->armyCalculator->calculateDefenseOnVillage($receiver);
        $attack  = $this->armyCalculator->calculatePowerOnExpedition($expedition);

        $win = $attack >= $defense;

        $receiver->decreaseArmy($attack);

        if (!$win) {
            $expedition->delete();
            return false;
        }

        $expedition->decreaseArmy($defense);

        $capacity  = $this->resourcesCalculator->calculateCapacityOnExpedition($expedition);
        $resources = $receiver->decreaseResourcesOnCapacity($capacity);

        $expeditionRoad = $this->roadCalculator->calculate($sender, $receiver);

        $data                = array_merge($resources, $expeditionRoad);
        $data['destination'] = 'back';

        $expedition->update($data);

        return true;
    }

    public function attackBack(Expedition $expedition)
    {
        $expedition->sender->addArmies($expedition);

        $expedition->sender->increment('food', $expedition->food);
        $expedition->sender->increment('gold', $expedition->gold);
        $expedition->delete();
    }
}
