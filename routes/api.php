<?php

Route::group([
    'middleware' => [
        \App\Http\Middleware\CheckPermissions::class,
    ],
], function () {
    require 'apis/api.landing.php';
    require 'apis/api.auth.php';
    require 'apis/api.scores.php';
    require __DIR__ . '/../app/Bundles/Contract/Http/routes/api.php';
    require 'apis/api.supplies.php';
    require 'apis/api.documents.php';
    require __DIR__ . '/../app/Bundles/ExternalNews/Http/Routes/api.php';
    require __DIR__ . '/../app/Bundles/Vocab/Http/routes/api.php';
    require 'apis/api.parsers.php';
    require 'apis/api.stat.php';
    require(__DIR__ . '/../vendor/dba/controltime/routes/api.php');
    require 'apis/api.controltime.php';
    require 'apis/api.logs.php';
    require __DIR__ . '/../app/Bundles/Employee/Http/routes/api.php';
});

require 'apis/api.tech_support.php';
