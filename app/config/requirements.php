<?php

return [
    'buildings' => [
        'gold_mine' => [
            2 => [
                'fortress' => 2,
            ],
            4 => [
                'fortress' => 3,
            ],
            6 => [
                'fortress' => 5,
            ],
            9 => [
                'fortress' => 8,
            ],
        ],
        'farm'      => [
            2 => [
                'fortress' => 2,
            ],
            4 => [
                'fortress' => 3,
            ],
            6 => [
                'fortress' => 5,
            ],
            9 => [
                'fortress' => 8,
            ],
        ],
        'smithy'    => [
            0 => [
                'barrack' => 3,
            ],
        ],
        'armory'    => [
            0 => [
                'barrack' => 5,
            ],
        ],
        'stable'    => [
            0 => [
                'barrack' => 7,
            ],
        ],
    ],

    'armies'    => [
        'pikeman'  => [
            'fortress' => 2,
            'barrack'  => 1,
        ],
        'swordman' => [
            'fortress' => 5,
            'barrack'  => 3,
            'smithy'   => 2,
        ],
        'archer'   => [
            'fortress' => 8,
            'barrack'  => 5,
            'smithy'   => 5,
            'armory'   => 7,
        ],
        'rider'    => [
            'fortress' => 10,
            'barrack'  => 7,
            'armory'   => 8,
            'stable'   => 9,
        ],
    ],
];
