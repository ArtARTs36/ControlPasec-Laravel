<?php

use Illuminate\Support\Facades\Route;

// API для справочника "Единицы измерения размера"

Route::apiResource('vocab/size-of-units', '\App\Bundles\Vocab\Http\Controllers\SizeOfUnitController');

// API для справочника "Единицы измерения"

Route::get(
    'vocab-quantity-units/page-{page}',
    '\App\Bundles\Vocab\Http\Controllers\VocabQuantityUnitController@index'
);

Route::apiResource(
    'vocab-quantity-units',
    '\App\Bundles\Vocab\Http\Controllers\VocabQuantityUnitController'
);

// API для справочника "ГОСТ"

Route::get(
    'vocab-gos-standards/page-{page}',
    '\App\Bundles\Vocab\Http\Controllers\VocabGosStandardController@index'
);

Route::apiResource(
    'vocab-gos-standards',
    '\App\Bundles\Vocab\Http\Controllers\VocabGosStandardController'
);

// API для справочника "Банки"

Route::get('vocab-banks/page-{page}', '\App\Bundles\Vocab\Http\Controllers\VocabBankController@index');
Route::apiResource('vocab-banks', '\App\Bundles\Vocab\Http\Controllers\VocabBankController');

// API для справочника "Курсы валют"

Route::get(
    'vocab-currencies/page-{page}',
    '\App\Bundles\Vocab\Http\Controllers\VocabCurrencyController@index'
);

Route::apiResource(
    'vocab-currencies',
    '\App\Bundles\Vocab\Http\Controllers\VocabCurrencyController'
);

Route::get(
    'vocab/currency-courses',
    '\App\Bundles\Vocab\Http\Controllers\CurrencyCourseController@chart'
);

// API для словаря

Route::get(
    'vocab-words/page-{page}',
    '\App\Bundles\Vocab\Http\Controllers\Vocab\VocabWordController@index'
);

Route::apiResource(
    'vocab-words',
    '\App\Bundles\Vocab\Http\Controllers\VocabWordController'
);

// API для справочника "Типы упаковок"

Route::apiResource(
    'vocab-package-types',
    '\App\Bundles\Vocab\Http\Controllers\VocabPackageTypeController'
);
