<?php

namespace App\Services;

use App\Models\Village;

interface VillageCalculator
{
    /**
     * @param Village $village
     * @return integer
     */
    public function calculate(Village $village): int;

    /**
     * @param integer $level
     * @return integer
     */
    public function calculateByLevel(int $level): int;
}
