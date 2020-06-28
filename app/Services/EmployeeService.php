<?php

namespace App\Services;

use App\Bundles\Employee\Models\Employee;
use Dba\ControlTime\Models\WorkCondition;
use Illuminate\Support\Arr;

class EmployeeService
{
    const FIELDS = [
        WorkCondition::FIELD_RATE,
        WorkCondition::FIELD_POSITION,
        WorkCondition::FIELD_AMOUNT_HOUR,
        WorkCondition::FIELD_AMOUNT_MONTH,
    ];

    public static function updateWorkConditions(Employee $employee, array $newConditions)
    {
        $newConditions = Arr::only($newConditions, static::FIELDS);

        if (!static::isRequireNewCondition($employee, $newConditions)) {
            return $employee->getCurrentWorkCondition();
        }

        return $employee->workConditions()->create($newConditions);
    }

    public static function isRequireNewCondition(Employee $employee, array $newConditions)
    {
        $currentConditions = $employee->getCurrentWorkCondition()->only(static::FIELDS);

        foreach ($currentConditions as $key => $currentCondition) {
            if ($newConditions[$key] != $currentCondition) {
                return true;
            }
        }

        return false;
    }
}
