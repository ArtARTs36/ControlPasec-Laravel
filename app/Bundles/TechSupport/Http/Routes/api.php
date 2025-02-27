<?php

use Illuminate\Support\Facades\Route;

// API для тех.поддержки

Route::get('tech-support-reports/page-{page}', 'TechSupportReportController@index');
Route::apiResource('tech-support-reports', 'TechSupportReportController')->only([
    'index',
    'store',
    'show',
]);

Route::prefix('tech-support-reports')->group(function () {
    Route::put('{report}/read', 'TechSupportReportController@read');
});
