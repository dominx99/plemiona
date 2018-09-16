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
    public function calculateByLevel(Village $village, int $level = null): int;
}
