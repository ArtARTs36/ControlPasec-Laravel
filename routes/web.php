<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('contragents/live-find/{term}', 'Contragent\ContragentController@liveFind');
Route::apiResource('contragents', 'Contragent\ContragentController');
Route::get('contragents/find-external-by-inn/{inn}', 'Contragent\ContragentController@findInExternalNetworkByInn');

Route::apiResource('contracts', 'Contract\ContractController');
Route::get('contracts/find-by-customer/{customerId}', 'Contract\ContractController@findByCustomer');

Route::apiResource('contract-templates', 'Contract\ContractTemplateController');

Route::apiResource('supplies', 'Supply\SupplyController');
Route::get('supplies/{supplyId}/torg12', 'Supply\SupplyController@createTorg12');
Route::get('supplies/find-by-customer/{customerId}', 'Supply\SupplyController@findByCustomer');

Route::apiResource('products', 'Product\ProductController');

Route::apiResource('my-contragents', 'Contragent\MyContragentController');

Route::apiResource('vocab/size-of-units', 'Vocab\SizeOfUnitController');

Route::apiResource('vocab/currencies', 'Vocab\VocabCurrencyController');

Route::get(
    'vocab/currency-courses',
    'Vocab\CurrencyCourseController@chart'
);

Route::apiResource('score-for-payments', 'Supply\ScoreForPaymentController');
Route::get(
    'score-for-payments/download-by-supply/{supplyId}',
    'Supply\ScoreForPaymentController@checkOrCreateDocumentBySupply'
);
Route::post(
    'score-for-payments/check-document-of-many',
    'Supply\ScoreForPaymentController@checkOrCreateDocumentOfManyScores'
);

Route::apiResource('documents', 'Document\DocumentController');
Route::get('documents/{id}/download', 'Document\DocumentController@download');

Route::apiResource('product-transport-waybills', 'Supply\ProductTransportWaybillController');
