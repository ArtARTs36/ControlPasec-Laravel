<?php

use Illuminate\Support\Facades\Route;

// API Для работы с договорами

Route::get('contracts/find-by-customer/{customerId}', 'ContractController@findByCustomer');
Route::get('contracts/page-{page}', 'ContractController@index');
Route::apiResource('contracts', 'ContractController');
Route::apiResource('contract-templates', 'ContractTemplateController');
