<?php

use Illuminate\Support\Facades\Route;

// API для сотрудников

Route::get('employees/live-find/{query}', 'Employee\EmployeeController@liveFind');
Route::get('employees/{employee}/document/{typeId}', 'Employee\EmployeeDocumentController@byType');
Route::get('employees/page-{page}', 'Employee\EmployeeController@index');
Route::apiResource('employees', 'Employee\EmployeeController');
