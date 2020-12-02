<?php

use Illuminate\Support\Facades\Route;

// API для статистики

Route::get('stat/general', [\App\Based\Http\Controllers\StatController::class, 'general']);
