<?php

use App\Bundles\Admin\Http\Controllers\AppHistoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('variable-definitions')->group(function () {
    Route::get('page-{page}', 'VariableDefinitionController@index');
});

Route::apiResource('variable-definitions', 'VariableDefinitionController')->only([
    'index',
    'show',
    'update',
]);

// LOGS

Route::get('security/logs/today', 'LogController@today');
Route::get('security/logs/search', 'LogController@find');
Route::get('security/logs/by-channel', 'LogController@findByChannel');
Route::get('security/logs/page-{page}', 'LogController@index');
Route::get('security/logs', 'LogController@index');

// Admin Services

Route::prefix('admin-services')->group(function () {
    Route::get('{name}', 'AdminServiceController@redirect');
});

// App Change History

Route::prefix('admin')->group(function () {
    Route::apiResource('app-history', 'AppHistoryController');
});
