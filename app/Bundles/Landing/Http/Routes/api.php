<?php

use Illuminate\Support\Facades\Route;

Route::get('landing/feedbacks/page-{page}', 'FeedBackController@index');
Route::apiResource('landing/feedbacks', 'FeedBackController');
