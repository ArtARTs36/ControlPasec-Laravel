<?php

use Illuminate\Support\Facades\Route;

// API для работы с группами контрагентов

Route::apiResource('contragent-groups', 'ContragentGroupController');
Route::get('contragent-groups/{group}/detach/{contragent}', 'ContragentGroupController@detach');
Route::get('contragent-groups/{group}/detach-all/', 'ContragentGroupController@detachAll');

// API для для работы с контрагентами

Route::get(
    'contragents/sync-with-external-system/{contragent}',
    'ContragentController@syncWithExternalSystem'
);
Route::get('contragents/page-{page}', 'ContragentController@index');
Route::get('contragents/live-find/{term}', 'ContragentController@liveFind');
Route::apiResource('contragents', 'ContragentController');
Route::get('contragents/find-external-by-inn/{inn}', 'ContragentController@findInExternalNetworkByInn');

//

Route::apiResource('contragent-managers', 'ContragentManagerController');
