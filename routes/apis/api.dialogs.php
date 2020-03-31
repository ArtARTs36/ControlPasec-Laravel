<?php

use Illuminate\Support\Facades\Route;

// API для для работы с диалогами

Route::prefix('dialog-messages')->group(function () {
    Route::put('{message}/read', 'Dialog\DialogMessageController@read');
});

Route::apiResource('dialog-messages', 'Dialog\DialogMessageController');

Route::prefix('dialogs')->group(function () {
    Route::get('user', 'Dialog\DialogController@user');
    Route::get('user/page-{page}', 'Dialog\DialogController@user');
});

Route::apiResource('dialogs', 'Dialog\DialogController');

