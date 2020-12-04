<?php

use Illuminate\Support\Facades\Route;

// API для поставок

Route::prefix('supplies')->group(function () {
    Route::post('store-many', 'SupplyController@storeMany');
    Route::get('find-by-customer/{customerId}', 'SupplyController@findByCustomer');
});

Route::apiResource('supplies', 'SupplyController');

// API Для счетов на оплату

Route::prefix('score-for-payments')->group(function () {
    Route::get('page-{page}', 'ScoreForPaymentController@index');
});

Route::apiResource('score-for-payments', 'ScoreForPaymentController');

Route::post(
    'score-for-payments/check-document-of-many',
    'ScoreForPaymentController@checkOrCreateDocumentOfManyScores'
);
