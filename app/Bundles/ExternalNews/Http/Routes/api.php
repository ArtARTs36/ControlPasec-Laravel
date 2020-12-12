<?php

use Illuminate\Support\Facades\Route;

Route::prefix('external-news')->group(function () {
    Route::get('truncate', 'ExternalNewsController@truncate');
    Route::get('page-{page}', 'ExternalNewsController@index');
    Route::get('chart', 'ExternalNewsController@chart');
    Route::get('chart/{count}', 'ExternalNewsController@chart');
});

Route::apiResource('external-news', 'ExternalNewsController')->only([
    'index',
    'show',
    'update',
    'destroy',
]);
Route::get('external-news-sources/page-{page}', 'ExternalNewsSourceController@index');
Route::apiResource('external-news-sources', 'ExternalNewsSourceController');
