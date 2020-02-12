<?php

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('contragents', 'Contragent\ContragentController');
Route::get('contragents/find-external-by-inn/{inn}', 'Contragent\ContragentController@findInExternalNetworkByInn');

Route::apiResource('contracts', 'Contract\ContractController');

Route::apiResource('supplies', 'Supply\SupplyController');

Route::apiResource('products', 'Product\ProductController');

Route::apiResource('my-contragents', 'Contragent\MyContragentController');

Route::apiResource('vocab/size-of-units', 'Vocab\SizeOfUnitController');

Route::apiResource('vocab/currencies', 'Vocab\VocabCurrencyController');
