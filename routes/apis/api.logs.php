<?php

use Illuminate\Support\Facades\Route;

Route::get('security/logs/today', 'LogController@today');
Route::get('security/logs/search', 'LogController@find');
Route::get('security/logs/by-channel', 'LogController@findByChannel');
Route::get('security/logs/page-{page}', 'LogController@index');
Route::get('security/logs', 'LogController@index');
