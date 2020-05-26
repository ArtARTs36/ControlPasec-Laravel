<?php

use Illuminate\Support\Facades\Route;

// API для ExternalNews

Route::get('external-news/truncate', 'News\ExternalNewsController@truncate');
Route::get('external-news/page-{page}', 'News\ExternalNewsController@index');
Route::get('external-news/chart', 'News\ExternalNewsController@chart');
Route::get('external-news/chart/{count}', 'News\ExternalNewsController@chart');
Route::apiResource('external-news', 'News\ExternalNewsController');
Route::get('external-news-sources/page-{page}', 'News\ExternalNewsSourceController@index');
Route::apiResource('external-news-sources', 'News\ExternalNewsSourceController');
