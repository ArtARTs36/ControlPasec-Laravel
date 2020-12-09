<?php

use Illuminate\Support\Facades\Route;

// API для словаря

Route::get('vocab-words/page-{page}', 'VocabWordController@index');
Route::apiResource('vocab-words', 'VocabWordController');

// API для курсов валют

Route::get('vocab/currency-courses', 'CurrencyCourseController@chart');

// API Vocab Package Type

Route::apiResource('vocab/package-types', 'VocabPackageTypeController');

// API для справочника "Единицы измерения размера"

Route::apiResource('vocab/size-of-units', 'SizeOfUnitController');

// API для справочника "Единицы измерения"

Route::get('vocab-quantity-units/page-{page}', 'VocabQuantityUnitController@index');
Route::apiResource('vocab-quantity-units', 'VocabQuantityUnitController');

// API для справочника "ГОСТ"

Route::get('vocab-gos-standards/page-{page}', 'VocabGosStandardController@index');
Route::apiResource('vocab-gos-standards', 'VocabGosStandardController');

// API для справочника "Банки"

Route::get('vocab-banks/page-{page}', 'VocabBankController@index');
Route::apiResource('vocab-banks', 'VocabBankController');

// API для справочника "Курсы валют"

Route::get('vocab-currencies/page-{page}', 'VocabCurrencyController@index');
Route::apiResource('vocab-currencies', 'VocabCurrencyController');
