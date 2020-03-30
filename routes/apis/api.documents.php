<?php

use Illuminate\Support\Facades\Route;

Route::get('/generate-document/{supply}/{typeId}', 'Document\DocumentGenerateController@generate');
Route::apiResource('documents', 'Document\DocumentController');
Route::get('documents/{id}/download', 'Document\DocumentController@download');

Route::apiResource('product-transport-waybills', 'Supply\ProductTransportWaybillController');
