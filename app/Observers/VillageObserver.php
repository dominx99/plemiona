<?php

namespace App\Observers;

use App\Models\Village;
use App\Services\FoodCalculator;
use App\Services\GoldCalculator;
use Carbon\Carbon;

class VillageObserver
{
    /**
     * @var \App\Services\GoldCalculator $gold
     */
    protected $gold;

    /**
     * @var \App\Services\FoodCalculator $food
     */
    protected $food;

    /**
     * @param \App\Services\GoldCalculator $gold
     * @param \App\Services\FoodCalculator $food
     */
    public function __construct(GoldCalculator $gold, FoodCalculator $food)
    {
        $this->gold = $gold;
        $this->food = $food;
    }

    /**
     * @param \App\Models\Village $village
     * @return void
     */
    public function retrieved(Village $village): void
    {
        $goldPerSec = $this->gold->calculate($village);
        $foodPerSec = $this->food->calculate($village);

        $now        = Carbon::now();
        $lastActive = Carbon::createFromTimeString($village->updated_at);

        $diff = $now->diffInSeconds($lastActive);

        $gold = $goldPerSec * $diff;
        $food = $foodPerSec * $diff;

        $village->increment('gold', $gold);
        $village->increment('food', $food);
    }
}
