<?php

use Illuminate\Support\Facades\Route;

// API Для счетов на оплату

Route::prefix('score-for-payments')->group(function () {
    Route::get('page-{page}', 'Supply\ScoreForPaymentController@index');
});

Route::apiResource('score-for-payments', 'Supply\ScoreForPaymentController');

Route::post(
    'score-for-payments/check-document-of-many',
    'Supply\ScoreForPaymentController@checkOrCreateDocumentOfManyScores'
);
