<?php

use Illuminate\Support\Facades\Route;

// API для товаров

Route::get('products/top-chart', 'Product\ProductController@topChart');
Route::get('products/refresh-top-chart', 'Product\ProductController@refreshTopChart');
Route::get('products/page-{page}', 'Product\ProductController@index');
Route::apiResource('products', 'Product\ProductController');
