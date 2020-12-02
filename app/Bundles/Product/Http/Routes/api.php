<?php

use Illuminate\Support\Facades\Route;

// API для товаров

Route::get('products/top-chart', 'ProductController@topChart');
Route::get('products/refresh-top-chart', 'ProductController@refreshTopChart');
Route::get('products/page-{page}', 'ProductController@index');
Route::apiResource('products', 'ProductController');
