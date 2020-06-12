<?php

use Illuminate\Support\Facades\Route;

// API для поставок

Route::prefix('supplies')->group(function () {
    Route::post('store-many', 'Supply\SupplyController@storeMany');
    Route::get('find-by-customer/{customerId}', 'Supply\SupplyController@findByCustomer');
});

Route::apiResource('supplies', 'Supply\SupplyController');
