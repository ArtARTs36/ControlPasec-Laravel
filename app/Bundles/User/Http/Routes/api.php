<?php

use Illuminate\Support\Facades\Route;

// API для профиля

Route::put('profiles/update-about-me', 'ProfileController@updateAboutMe');
Route::get('profiles/search/{query}', 'ProfileController@search')->middleware(
    'throttle:1555,1'
);
Route::apiResource('profiles', 'ProfileController');

//

Route::get('me', 'UserController@me');

Route::get('users/page-{page}', 'UserController@index');
Route::get('users/{user}/activate', 'UserController@activate');
Route::get('users/{user}/deactivate', 'UserController@deactivate');
Route::get('users/{user}/detach-role/{role}', 'UserController@detachRole');
Route::get('users/{user}/attach-role/{role}', 'UserController@attachRole');
Route::apiResource('users', 'UserController');

//

// Roles

Route::prefix('roles')->group(function () {
    Route::get('page-{page}', 'RoleController@index');
    Route::get('{role}/attach-allowed-for-sign', 'RoleController@attachAllowedForSignUp');
    Route::get('{role}/detach-allowed-for-sign', 'RoleController@detachAllowedForSignUp');
});

Route::apiResource('roles', 'RoleController');

// Permissions

Route::prefix('permissions')->group(function () {
    Route::get('page-{page}', 'PermissionController@index');
});

Route::apiResource('permissions', 'PermissionController');

Route::prefix('user-notifications')->group(function () {
    Route::put('{notification}/read', 'UserNotificationController@read');
});

// Auth

Route::get('signup-roles', 'User\RoleController@getRolesForSignUp');
Route::post('signup', 'Auth\RegisterController@store');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('token/revoke', 'Auth\AuthController@revokeToken');
    Route::post('refresh', 'Auth\AuthController@refresh');
    Route::post('token/issue', 'Auth\AuthController@issueToken');
    Route::post('token/refresh', 'Auth\AuthController@refreshToken');
});
