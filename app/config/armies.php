<?php

return [
    'all_armies'      => [
        [
            'type'     => 'pikeman',
            'name'     => 'Pikinierzy',
            'power'    => 5,
            'defense'  => 9,
            'capacity' => 20,
            'cost'     => 25,
            'time'     => 1,
        ],
        [
            'type'     => 'swordman',
            'name'     => 'Miecznicy',
            'power'    => 9,
            'defense'  => 5,
            'capacity' => 25,
            'cost'     => 30,
            'time'     => 1,
        ],
        [
            'type'     => 'archer',
            'name'     => 'Łucznicy',
            'power'    => 10,
            'defense'  => 20,
            'capacity' => 20,
            'cost'     => 35,
            'time'     => 2,
        ],
        [
            'type'     => 'rider',
            'name'     => 'Jeźdźcy',
            'power'    => 20,
            'defense'  => 10,
            'capacity' => 35,
            'cost'     => 40,
            'time'     => 2,
        ],
        [
            'type'     => 'giants',
            'name'     => 'Giganci',
            'power'    => 15,
            'defense'  => 33,
            'capacity' => 20,
            'cost'     => 45,
            'time'     => 3,
        ],
        [
            'type'     => 'assasins',
            'name'     => 'Skrytobójcy',
            'power'    => 33,
            'defense'  => 15,
            'capacity' => 45,
            'cost'     => 50,
            'time'     => 3,
        ],
    ],

    'armies_at_start' => [
        'pikeman',
        'swordman',
        'archer',
        'rider',
        'giants',
        'assasins',
    ],
];
