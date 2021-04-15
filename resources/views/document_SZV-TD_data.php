<?php

/** @var App\Bundles\Employee\Models\Employee $employee */

use Carbon\Carbon;

$employee = $document->employees()->first();

$wc = $employee->getCurrentWorkCondition();

$hiredDate = $wc ? $wc->getHireDate() : Carbon::now();

$employeeData = [
    'СОТРУДНИК_ФАМИЛИЯ' => $employee->getFamily(),
    'СОТРУДНИК_ИМЯ' => $employee->getName(),
    'СОТРУДНИК_ОТЧЕСТВО' => $employee->getPatronymic(),
    'СОТРУДНИК_ДР_ДЕНЬ' => $hiredDate->day,
    'СОТРУДНИК_ДР_МЕСЯЦ' => \ArtARTs36\RuSpelling\Month::getNominativeName($hiredDate->month),
    'СОТРУДНИК_ДР_ГОД' => $hiredDate->year,
    'СОТРУДНИК_СНИЛС' => $employee->insurance_number,
];

return array_merge($employeeData);
