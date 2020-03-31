<?php

use Illuminate\Support\Facades\Route;

// API для для работы с диалогами

Route::prefix('dialog-messages')->group(function () {
    Route::put('{message}/read', 'Dialog\DialogMessageController@read');
    Route::post('create-by-dialog/{dialog}', 'Dialog\DialogMessageController@createByDialog');
});

Route::apiResource('dialog-messages', 'Dialog\DialogMessageController');

Route::prefix('dialogs')->group(function () {
    Route::get('user', 'Dialog\DialogController@user');
    Route::get('user/page-{page}', 'Dialog\DialogController@user');
    Route::get('{dialog}/page-{page}', 'Dialog\DialogController@show');
});

Route::apiResource('dialogs', 'Dialog\DialogController');

