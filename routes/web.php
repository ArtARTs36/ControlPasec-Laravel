<?php

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('contragents', 'Contragent\ContragentController');
Route::get('contragents/find-external-by-inn/{inn}', 'Contragent\ContragentController@findInExternalNetworkByInn');

Route::apiResource('contracts', 'Contract\ContractController');

Route::apiResource('products', 'Product\ProductController');

Route::apiResource('my-contragents', 'Contragent\MyContragentController');
