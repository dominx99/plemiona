<?php

namespace App\Services;

use App\Config;
use App\Models\Expedition;
use App\Models\Village;

class ResourcesCalculator
{
    /**
     * @var \App\Config
     */
    protected $config;

    /**
     * @param \App\Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

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

    /**
     * @param \App\Models\Village $village
     * @param array $resources
     * @return void
     */
    public function increaseVillageResources(Village $village, array $resources): void
    {
        $limit = $this->calculateLimit($village);
        $gold  = $resources['gold'];
        $food  = $resources['food'];

        if (($village->gold + $gold) > $limit['gold']) {
            $village->update(['gold' => $limit['gold']]);
        } else {
            $village->increment('gold', $gold);
        }

        if (($village->food + $food) > $limit['food']) {
            $village->update(['food' => $limit['food']]);
        } else {
            $village->increment('food', $food);
        }
    }

    /**
     * @param \App\Models\Village $village
     * @return array
     */
    protected function calculateLimit(Village $village): array
    {
        $level = $village->getBuildingLevel('granary');
        $food  = $this->config->get('game.food_granary_ratio');
        $gold  = $this->config->get('game.gold_granary_ratio');

        return [
            'food' => $level * $food,
            'gold' => $level * $gold,
        ];
    }
}
