<?php

namespace App\Http\Requests\Employee;

use App\Models\Employee\Employee;
use Dba\ControlTime\Models\WorkCondition;
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
            Employee::FIELD_HIRED_DATE => 'required|string',

            static::prefixWc(WorkCondition::FIELD_RATE) => 'sometimes|double',
            static::prefixWc(WorkCondition::FIELD_AMOUNT_MONTH) => 'sometimes|integer',
            static::prefixWc(WorkCondition::FIELD_AMOUNT_HOUR) => 'sometimes|integer',
            static::prefixWc(WorkCondition::FIELD_POSITION) => 'sometimes|string',
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
