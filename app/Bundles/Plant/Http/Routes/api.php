<?php

use Illuminate\Support\Facades\Route;

Route::post('plants/productivity-forecast', 'ProductivityController@bring');
Route::get('plants/all', 'PlantController@showAll');
Route::apiResource('plants', 'PlantController');
Route::apiResource('plant/categories', 'CategoryController');
