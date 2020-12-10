<?php

Route::group([
    'middleware' => [
        \App\Http\Middleware\CheckPermissions::class,
    ],
], function () {
    require 'apis/api.parsers.php';
    require 'apis/api.stat.php';
    require(__DIR__ . '/../vendor/dba/controltime/routes/api.php');
    require 'apis/api.admin_services.php';
});
