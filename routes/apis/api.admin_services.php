<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin-services')->group(function () {
    Route::get('horizon', 'AdminServiceController@toHorizon');
});
