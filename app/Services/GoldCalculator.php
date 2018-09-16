<?php

namespace App\Services;

use App\Config;
use App\Models\Village;

class GoldCalculator implements VillageCalculator
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
        $this->perLevel = $config->get('game.gold_per_level');
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
            $level = $village->getBuildingLevel('gold_mine');
        }

        $value = $this->perLevel * $level;

        return ceil($value);
    }
}
