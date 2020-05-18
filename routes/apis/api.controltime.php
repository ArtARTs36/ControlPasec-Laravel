<?php

use Dba\ControlTime\Support\Proxy;
use Illuminate\Support\Facades\Route;

Route::get(
    Proxy::apiRoute('report') . '/{employee}/{start}/{end}',
    'ControlTime\TimeReportController@byPeriod'
);

Route::get(
    Proxy::apiRoute('report-month') . '/{employee}',
    'ControlTime\TimeReportController@byLastMonth'
);
