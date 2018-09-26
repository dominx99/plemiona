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
                'barrack' => 2,
            ],
        ],
        'armory'    => [
            0 => [
                'barrack' => 2,
            ],
        ],
        'stable'    => [
            0 => [
                'barrack' => 6,
            ],
        ],
    ],

    'armies'    => [
        'pikeman'  => [
            'fortress' => 5,
            'barrack'  => 2,
            'armory'   => 2,
        ],
        'swordman' => [
            'fortress' => 6,
            'barrack'  => 3,
            'smithy'   => 2,
        ],
        'archer'   => [
            'fortress' => 10,
            'barrack'  => 5,
            'armory'   => 7,
            'smithy'   => 5,
        ],
        'rider'    => [
            'fortress' => 11,
            'barrack'  => 7,
            'armory'   => 8,
            'stable'   => 6,
        ],
        'giants'   => [
            'fortress' => 14,
            'barrack'  => 10,
            'armory'   => 10,
            'smithy'   => 10,
        ],
        'assasins' => [
            'fortress' => 15,
            'barrack'  => 11,
            'smithy'   => 11,
            'stable'   => 9,
        ],
    ],
];
