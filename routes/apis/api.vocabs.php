<?php

use Illuminate\Support\Facades\Route;

// API для справочника "Единицы измерения размера"

Route::apiResource('vocab/size-of-units', 'Vocab\SizeOfUnitController');

// API для справочника "Единицы измерения"

Route::get('vocab-quantity-units/page-{page}', 'Vocab\VocabQuantityUnitController@index');
Route::apiResource('vocab-quantity-units', 'Vocab\VocabQuantityUnitController');

// API для справочника "ГОСТ"

Route::get('vocab-gos-standards/page-{page}', 'Vocab\VocabGosStandardController@index');
Route::apiResource('vocab-gos-standards', 'Vocab\VocabGosStandardController');

// API для справочника "Банки"

Route::get('vocab-banks/page-{page}', 'Vocab\VocabBankController@index');
Route::apiResource('vocab-banks', 'Vocab\VocabBankController');

// API для справочника "Курсы валют"

Route::get('vocab-currencies/page-{page}', 'Vocab\VocabCurrencyController@index');
Route::apiResource('vocab-currencies', 'Vocab\VocabCurrencyController');
