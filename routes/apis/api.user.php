<?php

use Illuminate\Support\Facades\Route;

// Roles

Route::prefix('roles')->group(function () {
    Route::get('page-{page}', 'User\RoleController@index');
    Route::get('{role}/attach-allowed-for-sign', 'User\RoleController@attachAllowedForSignUp');
    Route::get('{role}/detach-allowed-for-sign', 'User\RoleController@detachAllowedForSignUp');
});

Route::apiResource('roles', 'User\RoleController');

// Permissions

Route::prefix('permissions')->group(function () {
    Route::get('page-{page}', 'User\PermissionController@index');
});

Route::apiResource('permissions', 'User\PermissionController');

Route::prefix('user-notifications')->group(function () {
    Route::put('{notification}/read', 'User\UserNotificationController@read');
});
