<?php

return [
    'all_armies'      => [
        [
            'type'     => 'pikeman',
            'name'     => 'Pikinier',
            'power'    => 3,
            'defense'  => 7,
            'capacity' => 30,
            'cost'     => 20,
            'time'     => 2,
        ],
        [
            'type'     => 'swordman',
            'name'     => 'Miecznik',
            'power'    => 5,
            'defense'  => 5,
            'capacity' => 50,
            'cost'     => 30,
            'time'     => 3,
        ],
    ],

    'armies_at_start' => [
        'pikeman',
        'swordman',
    ],
];
