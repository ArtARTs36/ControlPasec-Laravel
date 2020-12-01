<?php

use Illuminate\Support\Facades\Route;

Route::get('me', 'UserController@me');

Route::get('users/page-{page}', 'UserController@index');
Route::get('users/{user}/activate', 'UserController@activate');
Route::get('users/{user}/deactivate', 'UserController@deactivate');
Route::get('users/{user}/detach-role/{role}', 'UserController@detachRole');
Route::get('users/{user}/attach-role/{role}', 'UserController@attachRole');
Route::apiResource('users', 'UserController');

Route::put('profiles/update-about-me', 'ProfileController@updateAboutMe');
Route::get('profiles/search/{query}', 'ProfileController@search')->middleware(
    'throttle:1555,1'
);
Route::apiResource('profiles', 'ProfileController');

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
