<?php

use Illuminate\Support\Facades\Route;

Route::prefix('variable-definitions')->group(function () {
    Route::get('page-{page}', 'VariableDefinitionController@index');
});

Route::apiResource('variable-definitions', 'VariableDefinitionController');
