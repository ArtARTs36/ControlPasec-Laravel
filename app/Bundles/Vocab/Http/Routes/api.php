<?php

use Illuminate\Support\Facades\Route;

// API для словаря

Route::get('vocab-words/page-{page}', 'VocabWordController@index');
Route::apiResource('vocab-words', 'VocabWordController');
