<?php

use Illuminate\Support\Facades\Route;

Route::prefix('external-news')->group(function () {
    Route::get('truncate', '\App\Bundles\ExternalNews\Http\Controllers\ExternalNewsController@truncate');
    Route::get('page-{page}', '\App\Bundles\ExternalNews\Http\Controllers\ExternalNewsController@index');
    Route::get('chart', '\App\Bundles\ExternalNews\Http\Controllers\ExternalNewsController@chart');
    Route::get('chart/{count}', '\App\Bundles\ExternalNews\Http\Controllers\ExternalNewsController@chart');
});

Route::apiResource('external-news', '\App\Bundles\ExternalNews\Http\Controllers\ExternalNewsController');
Route::get('external-news-sources/page-{page}', '\App\Bundles\ExternalNews\Http\Controllers\ExternalNewsSourceController@index');
Route::apiResource('external-news-sources', '\App\Bundles\ExternalNews\Http\Controllers\ExternalNewsSourceController');
