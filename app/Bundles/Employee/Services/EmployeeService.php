<?php

namespace App\Bundles\Employee\Services;

use App\Bundles\Employee\Models\Employee;
use App\Bundles\Employee\Models\WorkCondition;
use Illuminate\Support\Arr;

class EmployeeService
{
    protected const FIELDS = [
        WorkCondition::FIELD_RATE,
        WorkCondition::FIELD_POSITION,
        WorkCondition::FIELD_AMOUNT_HOUR,
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
        /** @var WorkCondition $currentConditions */
        $currentConditions = $employee->getCurrentWorkCondition();

        foreach ($currentConditions->only(static::FIELDS) as $key => $currentCondition) {
            if ($newConditions[$key] != $currentCondition) {
                return true;
            }
        }

        return false;
    }
}
