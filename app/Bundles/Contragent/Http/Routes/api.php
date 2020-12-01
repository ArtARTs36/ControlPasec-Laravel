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
Route::get('contragent-groups/{group}/detach-all/', 'Contragent\ContragentGroupController@detachAll');

//

Route::apiResource('contragent-managers', 'Contragent\ContragentManagerController');

Route::apiResource('my-contragents', 'Contragent\MyContragentController');

// API для для работы с диалогами

Route::prefix('dialog-messages')->group(function () {
    Route::put('{message}/read', 'DialogMessageController@read');
    Route::post('create-by-dialog/{dialog}', 'DialogMessageController@createByDialog');
});

Route::apiResource('dialog-messages', 'DialogMessageController');

Route::prefix('dialogs')->group(function () {
    Route::get('user', 'DialogController@user');
    Route::get('user/page-{page}', 'DialogController@user');
    Route::get('{dialog}/page-{page}', 'DialogController@show');
});

Route::apiResource('dialogs', 'DialogController');
