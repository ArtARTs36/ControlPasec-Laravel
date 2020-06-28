<?php

use Illuminate\Support\Facades\Route;

// API для сотрудников

Route::prefix('employees')->group(function () {
    Route::get('live-find/{query}', '\App\Bundles\Employee\Http\Controllers\EmployeeController@liveFind');
    Route::get('{employee}/document/{typeId}', '\App\Bundles\Employee\Http\Controllers\EmployeeDocumentController@byType');
    Route::get('page-{page}', '\App\Bundles\Employee\Http\Controllers\EmployeeController@index');
});

Route::apiResource('employees', '\App\Bundles\Employee\Http\Controllers\EmployeeController');
