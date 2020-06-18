<?php

namespace App\Http\Requests\Employee;

use App\Models\Employee\Employee;
use Dba\ControlTime\Models\WorkCondition;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            Employee::FIELD_FAMILY => 'required|string',
            Employee::FIELD_NAME => 'required|string',
            Employee::FIELD_PATRONYMIC => 'required|string',
            Employee::FIELD_HOLIDAY => 'required|string',
            Employee::FIELD_INSURANCE_NUMBER => 'required|string',
            Employee::FIELD_HIRED_DATE => 'required|string',

            'work_condition.'. WorkCondition::FIELD_RATE => 'sometimes|double',
            'work_condition.'. WorkCondition::FIELD_AMOUNT_MONTH => 'sometimes|integer',
            'work_condition.'. WorkCondition::FIELD_AMOUNT_HOUR => 'sometimes|integer',
            'work_condition.'. WorkCondition::FIELD_POSITION => 'sometimes|string',
        ];
    }

    public function getWorkCondition(): array
    {
        return $this->only(['work_condition'])['work_condition'];
    }
}
