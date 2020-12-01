<?php

use Illuminate\Support\Facades\Route;

// API для работы с группами контрагентов

Route::apiResource('contragent-groups', 'ContragentGroupController');
Route::get('contragent-groups/{group}/detach/{contragent}', 'ContragentGroupController@detach');
Route::get('contragent-groups/{group}/detach-all/', 'ContragentGroupController@detachAll');
