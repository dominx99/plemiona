<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'db'                  => [
            'driver'    => env('DATABASE_DRIVER', 'mysql'),
            'host'      => env('DATABASE_HOST', 'localhost'),
            'database'  => env('DATABASE_NAME', 'plemiona'),
            'username'  => env('DATABASE_USER', 'root'),
            'password'  => env('DATABASE_PASS', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => 'plemiona_',
        ],
    ],
];
