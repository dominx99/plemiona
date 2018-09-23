<?php

namespace App\Services;

use App\Models\Expedition;
use App\Repositories\ExpeditionRepository;
use App\Repositories\ReportRepository;
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
     * @var \App\Repositories\ExpeditionRepository
     */
    protected $expeditions;

    /**
     * @var \App\Repositories\ReportRepository
     */
    protected $reports;

    /**
     * @param \App\Services\ArmyCalculator $armyCalculator
     * @param \App\Services\ResourcesCalculator $resourcesCalculator
     * @param \App\Services\RoadCalculator $roadCalculator
     * @param \App\Repositories\ExpeditionRepository $expeditions
     * @param \App\Repositories\ReportRepository $reports
     */
    public function __construct(
        ArmyCalculator $armyCalculator,
        ResourcesCalculator $resourcesCalculator,
        RoadCalculator $roadCalculator,
        ExpeditionRepository $expeditions,
        ReportRepository $reports
    ) {
        $this->armyCalculator      = $armyCalculator;
        $this->resourcesCalculator = $resourcesCalculator;
        $this->roadCalculator      = $roadCalculator;
        $this->expeditions         = $expeditions;
        $this->reports             = $reports;
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

        $reportData = [
            'power'   => $attack,
            'defense' => $defense,
            'win'     => $win,
        ];

        $this->reports->createOnSender($expedition, $reportData);
        $this->reports->createOnReceiver($expedition, $reportData);

        if (!$win) {
            $this->expeditions->delete($expedition);
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

        $this->resourcesCalculator->increaseVillageResources($expedition->sender, [
            'gold' => $expedition->gold,
            'food' => $expedition->food,
        ]);

        $this->expeditions->delete($expedition);
    }
}
