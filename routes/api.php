<?php

Route::group([
    'middleware' => [
        \App\Based\Http\Middleware\CheckPermissions::class,
    ],
], function () {
    require 'apis/api.stat.php';
    require(__DIR__ . '/../vendor/dba/controltime/routes/api.php');
});
