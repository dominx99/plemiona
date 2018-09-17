<?php

namespace App\Services;

use App\Models\Expedition;

class ResourcesCalculator
{
    /**
     * @param Expedition $expedition
     * @return integer
     */
    public function calculateCapacityOnExpedition(Expedition $expedition): int
    {
        $capacity = 0;

        foreach ($expedition->armies as $army) {
            $capacity += $army->capacity * $army->pivot->amount;
        }

        return $capacity;
    }
}
