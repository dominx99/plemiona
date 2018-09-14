<?php

namespace App\Services;

use App\Models\Village;

class GoldCalculator extends Service implements VillageCalculator
{
    /**
     * @param \App\Models\Village $village
     * @return integer
     */
    public function calculate(Village $village): int
    {
        $level = $village->getBuildingLevel('gold_factory');

        return $this->calculateByLevel($level);
    }

    /**
     * @param integer $level
     * @return integer
     */
    public function calculateByLevel(int $level): int
    {
        $value = 1.618 * $level;

        return ceil($value);
    }
}
