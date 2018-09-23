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
            'type'     => 'archer',
            'name'     => 'Łucznicy',
            'power'    => 7,
            'defense'  => 11,
            'capacity' => 20,
            'cost'     => 45,
            'time'     => 4,
        ],
        [
            'type'     => 'rider',
            'name'     => 'Jeźdźcy',
            'power'    => 20,
            'defense'  => 5,
            'capacity' => 20,
            'cost'     => 50,
            'time'     => 4,
        ],
        [
            'type'     => 'giants',
            'name'     => 'Giganci',
            'power'    => 10,
            'defense'  => 25,
            'capacity' => 40,
            'cost'     => 60,
            'time'     => 5,
        ],
    ],

    'armies_at_start' => [
        'pikeman',
        'swordman',
        'archer',
        'rider',
        'giants',
    ],
];
