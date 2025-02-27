<?php

use App\Bundles\Employee\Reports\ExcelTemplateTimeReport;
use ArtARTs36\ControlTime\Loaders\Excel\Columns\CommentColumn;
use ArtARTs36\ControlTime\Loaders\Excel\Columns\DateColumn;
use ArtARTs36\ControlTime\Loaders\Excel\Columns\SubjectCodeColumn;
use ArtARTs36\ControlTime\Loaders\Excel\Columns\TabNumberColumn;
use ArtARTs36\ControlTime\Loaders\Excel\Columns\TimeQuantityColumn;
use ArtARTs36\ControlTime\Reports\Target\Period\CsvPeriodReport;
use ArtARTs36\ControlTime\Reports\Target\Period\JsonPeriodReport;

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
        'load_from_file' => [
            'excel' => [
                'fields' => [
                    'Субъект списания' => SubjectCodeColumn::class,
                    'Табельный номер' => TabNumberColumn::class,
                    'Время' => TimeQuantityColumn::class,
                    'Дата' => DateColumn::class,
                    'Комментарий' => CommentColumn::class,
                ],
            ],
        ],
    ],
    'routes' => [
        'api' => [
            'middleware' => [],
            'prefix' => 'api/controltime',
        ],
    ],
    'reports' => [
        'period' => [
            'csv' => CsvPeriodReport::class,
            'json' => JsonPeriodReport::class,
            'excel' => ExcelTemplateTimeReport::class,
        ],
    ],
];
