<?php

namespace App\Observers;

use App\Config;
use App\Models\User;
use App\Repositories\VillageRepository;

class UserObserver
{
    /**
     * @var \App\Repositories\VillageRepository
     */
    protected $villages;

    /**
     * @var integer
     */
    protected $food;

    /**
     * @var integer
     */
    protected $gold;

    /**
     * @param \App\Repositories\VillageRepository $villages
     * @param \App\Config $config
     */
    public function __construct(VillageRepository $villages, Config $config)
    {
        $this->villages = $villages;

        $this->gold = $config->get('game.gold_at_start');
        $this->food = $config->get('game.food_at_start');
    }

    /**
     * @param \App\Models\User $user
     * @return void
     */
    public function created(User $user): void
    {
        $other = false;

        do {
            $x = rand(1, 100);
            $y = rand(1, 100);

            $other = $this->villages->existsByCoordinates($x, $y);
        } while ($other);

        $name = "Wioska {$user->nick}'a";

        $user->villages()->create([
            'name' => $name,
            'x'    => $x,
            'y'    => $y,
            'food' => $this->food,
            'gold' => $this->gold,
        ]);
    }
}
