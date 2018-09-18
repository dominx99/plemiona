<?php

namespace App\Services;

use App\Models\Expedition;
use App\Services\ExpeditionCalculator;

class ArmyExpeditor
{
    /**
     * @param \App\Services\ExpeditionCalculator $expeditionCalculator
     */
    protected $expeditionCalculator;

    /**
     * @param \App\Services\ExpeditionCalculator $expeditionCalculator
     */
    public function __construct(ExpeditionCalculator $expeditionCalculator)
    {
        $this->expeditionCalculator = $expeditionCalculator;
    }

    /**
     * @param \App\Models\Expedition $expedition
     * @return void
     */
    public function endExpedition(Expedition $expedition)
    {
        if (!$expedition->canBeEnded()) {
            return false;
        }

        $this->expeditionCalculator->calculate($expedition);
    }
}
