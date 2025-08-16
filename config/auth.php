<?php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'usuarios',
    ],
    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'usuarios',
        ],

        'web' => [
            'driver' => 'session',
            'provider' => 'usuarios',
        ],
    ],
    'providers' => [
        'usuarios' => [
            'driver' => 'eloquent',
            'model' => \App\Models\Usuario::class,
        ],
    ],
    'passwords' => [
        'usuarios' => [
            'provider' => 'usuarios',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
    'password_timeout' => 10800,
];
