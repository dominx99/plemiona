<?php

namespace App\Services;

use App\Config;
use App\Models\Village;

class FoodCalculator implements VillageCalculator
{
    /**
     * @var integer $perLevel
     */
    protected $perLevel;

    /**
     * @param \App\Config $config
     */
    public function __construct(Config $config)
    {
        $this->perLevel = $config->get('game.food_per_level');
    }

    /**
     * @param \App\Models\Village $village
     * @return integer
     */
    public function calculate(Village $village): int
    {
        return $this->calculateByLevel($village);
    }

    /**
     * @param integer $level
     * @return integer
     */
    public function calculateByLevel(Village $village, int $level = null): int
    {
        if (!$level) {
            $level = $village->getBuildingLevel('farm');
        }

        $value = $this->perLevel * $level;

        return ceil($value);
    }
}
