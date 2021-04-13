<?php

return [
    'routes' => [
        'api' => [
            'middleware' => [],
            'prefix' => 'api/file-storage',
        ],
    ],
    'user' => [
        'model' => \Illuminate\Foundation\Auth\User::class,
    ],
];
