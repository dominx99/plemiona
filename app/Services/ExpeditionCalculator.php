<?php

namespace App\Services;

use App\Models\Expedition;
use App\Services\ArmyCalculator;
use App\Services\ResourcesCalculator;

class ExpeditionCalculator
{
    /**
     * @var \App\Services\ArmyCalculator
     */
    protected $armyCalculator;

    /**
     * @var \App\Models\Village
     */
    protected $sender;

    /**
     * @var \App\Services\ResourcesCalculator
     */
    protected $resourcesCalculator;

    /**
     * @param \App\Services\ArmyCalculator $armyCalculator
     */
    public function __construct(
        ArmyCalculator $armyCalculator,
        ResourcesCalculator $resourcesCalculator
    ) {
        $this->armyCalculator      = $armyCalculator;
        $this->resourcesCalculator = $resourcesCalculator;
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

        $resources['destination'] = 'back';
        $expedition->update($resources);

        return true;
    }

    public function attackBack(Expedition $expedition)
    {
        $this->sender->addArmies($expedition);

        $this->sender->increment('food', $expedition->food);
        $this->sender->increment('gold', $expedition->gold);
        die();
        // $expedition->delete();
    }
}
