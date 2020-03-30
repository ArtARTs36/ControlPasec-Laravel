<?php

use Illuminate\Support\Facades\Route;

// API для поставок

Route::get('supplies/page-{page}', 'Supply\SupplyController@index');
Route::apiResource('supplies', 'Supply\SupplyController');
Route::get('supplies/find-by-customer/{customerId}', 'Supply\SupplyController@findByCustomer');
