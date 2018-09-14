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
        $level = $village->getBuildingLevel('food_factory');

        return $this->calculateByLevel($level);
    }

    /**
     * @param integer $level
     * @return integer
     */
    public function calculateByLevel(int $level): int
    {
        $value = $this->perLevel * $level;

        return ceil($value);
    }
}
