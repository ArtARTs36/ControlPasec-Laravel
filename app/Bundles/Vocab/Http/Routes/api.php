<?php

use Illuminate\Support\Facades\Route;

// API для словаря

Route::get('vocab-words/page-{page}', 'VocabWordController@index');
Route::apiResource('vocab-words', 'VocabWordController');

// API для курсов валют

Route::get('vocab/currency-courses', 'CurrencyCourseController@chart');

// API Vocab Package Type

Route::apiResource('vocab/package-types', 'VocabPackageTypeController');
