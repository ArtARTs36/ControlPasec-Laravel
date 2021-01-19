<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('plants', 'PlantController');

Route::apiResource('plant/categories', 'CategoryController');
