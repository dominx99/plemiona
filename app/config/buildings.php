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
            'type'  => 'barrack',
            'name'  => 'Koszary',
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
            'level' => 1,
        ],
        'barrack'   => [
            'level' => 0,
        ],
    ],

    'gold_mine'          => [
        'cost_ratio' => 1.618 * 50,
        'time_ratio' => 0.618 * 5,
    ],

    'farm'               => [
        'cost_ratio' => 1.618 * 50,
        'time_ratio' => 0.618 * 4,
    ],

    'fortress'           => [
        'cost_ratio' => 1.618 * 250,
        'time_ratio' => 0.618 * 5,
    ],

    'barrack'            => [
        'cost_ratio' => 1.618 * 500,
        'time_ratio' => 0.618 * 7,
    ],
];
