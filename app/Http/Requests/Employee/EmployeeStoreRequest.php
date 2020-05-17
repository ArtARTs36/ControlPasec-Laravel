<?php

namespace App\Http\Requests\Employee;

use App\Models\Employee\Employee;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            Employee::FIELD_FAMILY => 'required|string',
            Employee::FIELD_NAME => 'required|string',
            Employee::FIELD_PATRONYMIC => 'required|string',
        ];
    }
}
