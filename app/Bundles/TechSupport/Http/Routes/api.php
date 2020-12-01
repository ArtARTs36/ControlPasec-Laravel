<?php

use Illuminate\Support\Facades\Route;

// API для тех.поддержки

Route::get('tech-support-reports/page-{page}', 'TechSupportReportController@index');
Route::apiResource('tech-support-reports', 'TechSupportReportController');
