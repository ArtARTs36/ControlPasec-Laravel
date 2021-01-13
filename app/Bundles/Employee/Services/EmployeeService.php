<?php

namespace App\Bundles\Employee\Services;

use App\Bundles\Employee\Models\Employee;
use ArtARTs36\ControlTime\Models\WorkCondition;
use Illuminate\Support\Arr;

class EmployeeService
{
    protected const FIELDS = [
        WorkCondition::FIELD_RATE,
        WorkCondition::FIELD_POSITION,
        WorkCondition::FIELD_AMOUNT_HOUR,
        WorkCondition::FIELD_AMOUNT_MONTH,
    ];

    public function updateWorkConditions(Employee $employee, array $newConditions)
    {
        $newConditions = Arr::only($newConditions, static::FIELDS);

        if (! $this->isRequireNewCondition($employee, $newConditions)) {
            return $employee->getCurrentWorkCondition();
        }

        return $employee->workConditions()->create($newConditions);
    }

    public function isRequireNewCondition(Employee $employee, array $newConditions)
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
