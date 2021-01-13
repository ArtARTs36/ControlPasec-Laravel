<?php

return [
    'employee' => [
        'model_class' => \App\Bundles\Employee\Models\Employee::class,
        'table' => 'controltime_employee',
    ],
    'time' => [
        'model_class' => \ArtARTs36\ControlTime\Models\Time::class,
        'date_format' => 'Y-m-d',
        'index_showing' => [
            'page_count' => 10,
        ],
    ],
    'routes' => [
        'api' => [
            'middleware' => [],
            'prefix' => 'api/controltime',
        ],
    ],
];
