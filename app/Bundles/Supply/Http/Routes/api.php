<?php

use Illuminate\Support\Facades\Route;

// API для поставок

Route::prefix('supplies')->group(function () {
    Route::post('store-many', 'SupplyController@storeMany');
    Route::get('find-by-customer/{customerId}', 'SupplyController@findByCustomer');
});

Route::apiResource('supplies', 'SupplyController');
