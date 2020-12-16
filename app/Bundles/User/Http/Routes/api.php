<?php

use Illuminate\Support\Facades\Route;

// API для профиля

Route::put('profiles/update-about-me', 'ProfileController@updateAboutMe');
Route::get('profiles/search/{query}', 'ProfileController@search')->middleware(
    'throttle:1555,1'
);
Route::apiResource('profiles', 'ProfileController')->only([
    'show',
]);

//

Route::get('me', 'UserController@me');

Route::get('users/page-{page}', 'UserController@index');
Route::get('users/{user}/activate', 'UserController@activate');
Route::get('users/{user}/deactivate', 'UserController@deactivate');
Route::get('users/{user}/detach-role/{role}', 'UserController@detachRole');
Route::get('users/{user}/attach-role/{role}', 'UserController@attachRole');
Route::apiResource('users', 'UserController')->only([
    'index',
    'show',
    'update',
    'store',
]);

//

// Roles

Route::prefix('roles')->group(function () {
    Route::get('page-{page}', 'RoleController@index');
    Route::get('{role}/attach-allowed-for-sign', 'RoleController@attachAllowedForSignUp');
    Route::get('{role}/detach-allowed-for-sign', 'RoleController@detachAllowedForSignUp');
});

Route::apiResource('roles', 'RoleController')->only([
    'index',
]);

// Permissions

Route::prefix('permissions')->group(function () {
    Route::get('page-{page}', 'PermissionController@index');
});

Route::apiResource('permissions', 'PermissionController')->only([
    'index',
]);

Route::prefix('user-notifications')->group(function () {
    Route::put('{notification}/read', 'UserNotificationController@read');
});

// Auth

Route::get('signup-roles', 'RoleController@getRolesForSignUp');
Route::post('signup', '\App\Bundles\User\Http\Controllers\Auth\RegisterController@store');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('token/revoke', '\App\Bundles\User\Http\Controllers\Auth\AuthController@revokeToken');
    Route::post('refresh', '\App\Bundles\User\Http\Controllers\Auth\AuthController@refreshToken');
    Route::post('token/issue', '\App\Bundles\User\Http\Controllers\Auth\AuthController@issueToken');
    Route::post('token/refresh', '\App\Bundles\User\Http\Controllers\Auth\AuthController@refreshToken');
});

// Dialogs

// API для для работы с диалогами

Route::prefix('dialog-messages')->group(function () {
    Route::put('{message}/read', 'DialogMessageController@read');
    Route::post('create-by-dialog/{dialog}', 'DialogMessageController@createByDialog');
});

Route::apiResource('dialog-messages', 'DialogMessageController')->only([
    'store',
]);

Route::prefix('dialogs')->group(function () {
    Route::get('user', 'DialogController@user');
    Route::get('user/page-{page}', 'DialogController@user');
    Route::get('{dialog}/page-{page}', 'DialogController@show');
});

Route::apiResource('dialogs', 'DialogController')->only([
    'index',
    'show',
    'destroy',
]);
