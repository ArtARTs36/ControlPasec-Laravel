<?php

use Illuminate\Support\Facades\Route;

Route::apiResource(
    'text-data-parser-components',
    'TextDataParser\TextDataParserComponentController'
);
