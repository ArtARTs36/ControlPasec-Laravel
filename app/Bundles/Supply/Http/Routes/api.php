<?php

use Illuminate\Support\Facades\Route;

// API для поставок

Route::prefix('supplies')->group(function () {
    Route::post('store-many', 'SupplyController@storeMany');
    Route::get('find-by-customer/{customerId}', 'SupplyController@findByCustomer');
    Route::post('{supply}/transition/{rule}', 'SupplyController@transition');
});

Route::get('supplies/{supply}/history', 'SupplyController@history');
Route::apiResource('supplies', 'SupplyController');

Route::get('supply-status-rules/diagram', 'SupplyStatusRuleController@diagram');
Route::apiResource('supply-status-rules', 'SupplyStatusRuleController');

// API Для счетов на оплату

Route::prefix('score-for-payments')->group(function () {
    Route::get('page-{page}', 'ScoreForPaymentController@index');
});

Route::apiResource('score-for-payments', 'ScoreForPaymentController');

Route::post(
    'score-for-payments/check-document-of-many',
    'ScoreForPaymentController@checkOrCreateDocumentOfManyScores'
);

// API Для работы с договорами

Route::get('contracts/find-by-customer/{customerId}', 'ContractController@findByCustomer');
Route::get('contracts/page-{page}', 'ContractController@index');
Route::apiResource('contracts', 'ContractController');
Route::apiResource('contract-templates', 'ContractTemplateController');

//

Route::apiResource('product-transport-waybills', 'ProductTransportWaybillController');
