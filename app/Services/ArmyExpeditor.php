<?php

namespace App\Services;

use App\Models\Expedition;
use App\Models\Village;
use App\Services\ExpeditionCalculator;

class ArmyExpeditor
{
    /**
     * @param \App\Services\ExpeditionCalculator $expeditionCalculator
     */
    protected $expeditionCalculator;

    public function __construct(ExpeditionCalculator $expeditionCalculator)
    {
        $this->expeditionCalculator = $expeditionCalculator;
    }

    public function endExpeditions(Village $village)
    {
        $expeditions = $village->expeditions;

        foreach ($expeditions as $expedition) {
            $this->endExpedition($expedition);
        }
    }

    public function endExpedition(Expedition $expedition)
    {
        if (!$expedition->canBeEnded()) {
            return false;
        }

        $this->expeditionCalculator->calculate($expedition);
    }
}
