<?php

/** @var App\Bundles\Employee\Models\Employee $employee */
$employee = $document->employees()->first();

$hiredDate = \Carbon\Carbon::parse($employee->hired_date);

$employeeData = [
    'СОТРУДНИК_ФАМИЛИЯ' => $employee->getFamily(),
    'СОТРУДНИК_ИМЯ' => $employee->getName(),
    'СОТРУДНИК_ОТЧЕСТВО' => $employee->getPatronymic(),
    'СОТРУДНИК_ДР_ДЕНЬ' => $hiredDate->day,
    'СОТРУДНИК_ДР_МЕСЯЦ' => \App\Services\SpellingService::getMonthNameById($hiredDate->month),
    'СОТРУДНИК_ДР_ГОД' => $hiredDate->year,
    'СОТРУДНИК_СНИЛС' => $employee->insurance_number,
];

return array_merge($employeeData);
