<?php

use Illuminate\Support\Facades\Route;

// API Для работы с договорами

Route::get('contracts/find-by-customer/{customerId}', 'Contract\ContractController@findByCustomer');
Route::get('contracts/page-{page}', 'Contract\ContractController@index');
Route::apiResource('contracts', 'Contract\ContractController');
Route::apiResource('contract-templates', 'Contract\ContractTemplateController');
Route::apiResource('my-contragents', 'Contragent\MyContragentController');
