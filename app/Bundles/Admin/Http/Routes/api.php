<?php

use Illuminate\Support\Facades\Route;

Route::prefix('variable-definitions')->group(function () {
    Route::get('page-{page}', 'VariableDefinitionController@index');
});

Route::apiResource('variable-definitions', 'VariableDefinitionController');

// LOGS

Route::get('security/logs/today', 'LogController@today');
Route::get('security/logs/search', 'LogController@find');
Route::get('security/logs/by-channel', 'LogController@findByChannel');
Route::get('security/logs/page-{page}', 'LogController@index');
Route::get('security/logs', 'LogController@index');
