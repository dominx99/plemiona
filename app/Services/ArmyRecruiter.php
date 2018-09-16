<?php

namespace App\Services;

use App\Config;
use App\Models\Village;
use App\Repositories\ArmyRepository;
use App\Repositories\TimingRepository;
use Carbon\Carbon;

class ArmyRecruiter
{
    /**
     * @var \App\Repositories\ArmyRepository
     */
    protected $armies;

    /**
     * @var \App\Repositories\TimingRepository
     */
    protected $timings;

    /**
     * @var \App\Config
     */
    protected $config;

    /**
     * @param \App\Repositories\ArmyRepository $armies
     * @param \App\Repositories\TimingRepository $timings
     * @param \App\Config $config
     */
    public function __construct(
        ArmyRepository $armies,
        TimingRepository $timings,
        Config $config
    ) {
        $this->armies  = $armies;
        $this->timings = $timings;
        $this->config  = $config;
    }

    /**
     * @param \App\Models\Village $village
     * @return void
     */
    public function recruitForVillage(Village $village)
    {
        $now = Carbon::now();

        foreach ($village->armyTimings as $timing) {
            if (!$timing->active) {
                continue;
            }

            $armyDoneAt = Carbon::createFromTimeString($timing->done_at);
            if ($now > $armyDoneAt) {
                $army = $this->armies->findByVillage($village, $timing->object_id);
                $army->increaseAmount($timing->amount);

                $timing->delete();
            }
        }
    }

    /**
     * @param \App\Models\Village $village
     * @return void
     */
    public function setNewActive(Village $village): void
    {
        $possibleActive = $this->config->get('game.possible_active_armies');

        if (
            $this->timings->getActiveArmiesCount($village) < $possibleActive &&
            $this->timings->getAllArmiesCount($village) > $this->timings->getActiveArmiesCount($village)
        ) {

            if ($timing = $this->timings->getLastArmyTiming($village)) {
                $time = Carbon::now()->addSeconds($timing->time);
                $timing->setActive($time);
            }

        }
    }
}
