<?php

use Illuminate\Support\Facades\Route;

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
