<?php

namespace App\Bundles\Employee\Http\Requests;

use App\Bundles\Employee\Models\Employee;
use App\Bundles\Employee\Models\WorkCondition;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
{
    public const PREFIX_WORK_CONDITION = 'work_condition';

    public function rules(): array
    {
        return [
            Employee::FIELD_FAMILY => 'required|string',
            Employee::FIELD_NAME => 'required|string',
            Employee::FIELD_PATRONYMIC => 'required|string',
            Employee::FIELD_HOLIDAY => 'required|string',
            Employee::FIELD_INSURANCE_NUMBER => 'required|string',

            static::prefixWc(WorkCondition::FIELD_RATE) => 'sometimes|double',
            static::prefixWc(WorkCondition::FIELD_AMOUNT_HOUR) => 'sometimes|integer',
            static::prefixWc(WorkCondition::FIELD_POSITION) => 'sometimes|string',
            static::prefixWc(WorkCondition::FIELD_TAB_NUMBER) => 'sometimes|string',
            static::prefixWc(WorkCondition::FIELD_HIRE_DATE) => 'sometimes|string',
            static::prefixWc(WorkCondition::FIELD_FIRE_DATE) => 'nullable|sometimes|string',
        ];
    }

    public static function prefixWc($suffix): string
    {
        return static::PREFIX_WORK_CONDITION . '.' . $suffix;
    }

    public function getWorkCondition(): ?array
    {
        return $this->get('work_condition') ?
            $this->only(['work_condition'])['work_condition'] :
            null;
    }
}
