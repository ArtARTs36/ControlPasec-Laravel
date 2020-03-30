<?php

use Illuminate\Support\Facades\Route;

// API для статистики

Route::get('stat/general', 'Stat\StatController@general');
