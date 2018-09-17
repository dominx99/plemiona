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
            'power'    => 5,
            'defense'  => 5,
            'capacity' => 50,
            'cost'     => 30,
            'time'     => 3,
        ],
        [
            'type'    => 'archer',
            'name'    => 'Łucznicy',
            'power'   => 5,
            'defense' => 10,
            'capacit' => 20,
            'cost'    => 45,
            'time'    => 5,
        ],
        [
            'type'     => 'rider',
            'name'     => 'Jeźdźcy',
            'power'    => 15,
            'defense'  => 1,
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
