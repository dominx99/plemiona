<?php

namespace App\Services;

use App\Config;
use App\Models\Village;
use Carbon\Carbon;

class RoadCalculator
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
     * @param \App\Models\Village $sender
     * @param \App\Models\Village $receiver
     * @return array
     */
    public function calculate(Village $sender, Village $receiver): array
    {
        $width    = abs($sender->x - $receiver->x);
        $height   = abs($sender->y - $receiver->y);
        $diagonal = sqrt(pow($width, 2) + pow($height, 2)); // wzór na przekątną kwadratu

        $ratio = $this->config->get('game.armies_march_ratio');

        $time    = round($diagonal, 0) * $ratio;
        $reachAt = Carbon::now()->addSeconds($time);

        return [
            // 'time'     => $time, // * don't need that for now
            'reach_at' => $reachAt,
        ];
    }
}
