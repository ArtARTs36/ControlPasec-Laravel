<?php

return [
    'employee' => [
        'model_class' => \App\Bundles\Employee\Models\Employee::class,
        'table' => 'controltime_employee',
    ],
    'work_condition' => [
        'model_class' => \Dba\ControlTime\Models\WorkCondition::class,
    ],
    'time' => [
        'model_class' => \Dba\ControlTime\Models\Time::class,
        'table' => 'controltime_times',
        'date_format' => 'Y-m-d',
        'index_showing' => [
            'page_count' => 10,
        ],
    ],
    'api_route_prefix' => 'controltime',
];
