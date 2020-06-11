<?php

use Illuminate\Support\Facades\Route;

// API для для работы с контрагентами

Route::get(
    'contragents/sync-with-external-system/{contragent}',
    'Contragent\ContragentController@syncWithExternalSystem'
);
Route::get('contragents/page-{page}', 'Contragent\ContragentController@index');
Route::get('contragents/live-find/{term}', 'Contragent\ContragentController@liveFind');
Route::apiResource('contragents', 'Contragent\ContragentController');
Route::get('contragents/find-external-by-inn/{inn}', 'Contragent\ContragentController@findInExternalNetworkByInn');

//

Route::apiResource('contragent-groups', 'Contragent\ContragentGroupController');
Route::get('contragent-groups/{group}/detach/{contragent}', 'Contragent\ContragentGroupController@detach');

//

Route::apiResource('contragent-managers', 'Contragent\ContragentManagerController');
