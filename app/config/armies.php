<?php

return [
    'all_armies'      => [
        [
            'type'     => 'pikeman',
            'name'     => 'Pikinierzy',
            'power'    => 3,
            'defense'  => 7,
            'capacity' => 30,
            'cost'     => 20,
            'time'     => 3,
        ],
        [
            'type'     => 'swordman',
            'name'     => 'Miecznicy',
            'power'    => 9,
            'defense'  => 5,
            'capacity' => 50,
            'cost'     => 30,
            'time'     => 3,
        ],
        [
            'type'    => 'archer',
            'name'    => 'Łucznicy',
            'power'   => 12,
            'defense' => 15,
            'capacit' => 20,
            'cost'    => 45,
            'time'    => 5,
        ],
        [
            'type'     => 'rider',
            'name'     => 'Jeźdźcy',
            'power'    => 25,
            'defense'  => 5,
            'capacity' => 20,
            'cost'     => 50,
            'time'     => 5,
        ],
    ],

    'armies_at_start' => [
        'pikeman',
        'swordman',
        'archer',
        'rider',
    ],
];
