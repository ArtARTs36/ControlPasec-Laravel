<?php

use Illuminate\Support\Facades\Route;

// API для статистики

Route::get('stat/general', [\App\Based\Http\Controllers\StatController::class, 'general']);

// API для календаря

Route::get('calendar', [\App\Based\Http\Controllers\CalendarController::class, 'showByDates']);
