<?php

Route::group([
    'middleware' => [
        \App\Http\Middleware\CheckPermissions::class,
    ],
], function () {
    require_once 'apis/api.landing.php';
    require_once 'apis/api.auth.php';
    require_once 'apis/api.user.php';
    require_once 'apis/api.scores.php';
    require_once 'apis/api.contragents.php';
    require_once 'apis/api.contracts.php';
    require_once 'apis/api.supplies.php';
    require_once 'apis/api.products.php';
    require_once 'apis/api.documents.php';
    require_once 'apis/api.vocabs.php';
    require_once 'apis/api.external_news.php';
    require_once 'apis/api.variable_definitions.php';
    require_once 'apis/api.parsers.php';
    require_once 'apis/api.dialogs.php';
    require_once 'apis/api.stat.php';
    require_once(__DIR__ . '/../vendor/dba/controltime/routes/api.php');
    require_once 'apis/api.employees.php';
    require_once 'apis/api.controltime.php';
    require_once 'apis/api.admin_services.php';
});

require_once 'apis/api.tech_support.php';

