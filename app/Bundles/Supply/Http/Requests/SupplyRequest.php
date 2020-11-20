<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'planned_date' => 'required',
            'execute_date' => 'required'
        ];
    }
}
