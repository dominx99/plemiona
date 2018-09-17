<?php

namespace App\Services;

use App\Models\Expedition;
use App\Models\Village;

class ArmyCalculator
{
    /**
     * @param Village $village
     * @return integer
     */
    public function calculateDefenseOnVillage(Village $village): int
    {
        $defense = 0;

        foreach ($village->armies as $army) {
            $defense += $army->defense * $army->pivot->amount;
        }

        return $defense;
    }

    /**
     * @param \App\Models\Expedition $expedition
     * @return integer
     */
    public function calculatePowerOnExpedition(Expedition $expedition): int
    {
        $power = 0;

        foreach ($expedition->armies as $army) {
            $power += $army->power * $army->pivot->amount;
        }

        return $power;
    }
}
