<?php

return [
    'all_buildings'      => [
        0 => [
            'type'  => 'fortress',
            'name'  => 'Twierdza',
            'color' => 'yellow',
        ],
        1 => [
            'type'  => 'gold_mine',
            'name'  => 'Kopalnia złota',
            'color' => 'yellow',
        ],
        2 => [
            'type'  => 'farm',
            'name'  => 'Farma',
            'color' => 'yellow',
        ],
        3 => [
            'type'  => 'granary',
            'name'  => 'Spichlerz',
            'color' => 'yellow',
        ],
        4 => [
            'type'  => 'barrack',
            'name'  => 'Koszary',
            'color' => 'yellow',
        ],
        5 => [
            'type'  => 'smithy',
            'name'  => 'Kuźnia',
            'color' => 'yellow',
        ],
        6 => [
            'type'  => 'stable',
            'name'  => 'Stajnia',
            'color' => 'yellow',
        ],
        7 => [
            'type'  => 'armory',
            'name'  => 'Zbrojownia',
            'color' => 'yellow',
        ],
    ],

    'buildings_at_start' => [
        'fortress'  => [
            'level' => 1,
        ],
        'gold_mine' => [
            'level' => 1,
        ],
        'farm'      => [
            'level' => 0,
        ],
        'granary'   => [
            'level' => 1,
        ],
        'barrack'   => [
            'level' => 0,
        ],
        'smithy'    => [
            'level' => 0.,
        ],
        'armory'    => [
            'level' => 0,
        ],
        'stable'    => [
            'level' => 0,
        ],
    ],

    'gold_mine'          => [
        'cost_ratio' => 1.618 * 75,
        'time_ratio' => 0.618 * 4,
    ],

    'farm'               => [
        'cost_ratio' => 1.618 * 80,
        'time_ratio' => 0.618 * 5,
    ],

    'granary'            => [
        'cost_ratio' => 1.618 * 140,
        'time_ratio' => 0.618 * 5,
    ],

    'fortress'           => [
        'cost_ratio' => 1.618 * 120,
        'time_ratio' => 0.618 * 6,
    ],

    'barrack'            => [
        'cost_ratio' => 1.618 * 200,
        'time_ratio' => 0.618 * 6,
    ],

    'smithy'             => [
        'cost_ratio' => 1.618 * 175,
        'time_ratio' => 0.618 * 5,
    ],

    'armory'             => [
        'cost_ratio' => 1.618 * 175,
        'time_ratio' => 0.618 * 5,
    ],

    'stable'             => [
        'cost_ratio' => 1.618 * 175,
        'time_ratio' => 0.618 * 5,
    ],
];
