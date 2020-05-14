<?php

return [
    'employee' => [
        'model_class' => '',
        'table' => 'controltime_employee',
    ],
    'work_condition' => [
        'model_class' => \Dba\ControlTime\Models\WorkCondition::class,
    ],
    'time' => [
        'model_class' => \Dba\ControlTime\Models\Time::class,
        'table' => 'controltime_times',
        'date_format' => 'Y-m-d',
    ],
];
