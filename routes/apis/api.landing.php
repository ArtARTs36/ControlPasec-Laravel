<?php

use Illuminate\Support\Facades\Route;

Route::post('/landing/send-feedback', 'Landing\LandingFeedBackController@store');

Route::apiResource('landing-feedbacks', 'Landing\LandingFeedBackController');
