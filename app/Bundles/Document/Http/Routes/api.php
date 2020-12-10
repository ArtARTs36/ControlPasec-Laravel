<?php

use Illuminate\Support\Facades\Route;

Route::get('/archives/{timestamp}/{name}', 'ArchiveController@download');

Route::get('/generate-document/{supply}/{typeId}', 'DocumentGenerateController@generate');
Route::get('/create-document/{typeId}', 'DocumentGenerateController@create');
Route::post('/generate-documents/{supply}/', 'DocumentGenerateController@generateManyTypes');
Route::apiResource('documents', 'DocumentController');
Route::get('documents/{id}/download', 'DocumentController@download');
