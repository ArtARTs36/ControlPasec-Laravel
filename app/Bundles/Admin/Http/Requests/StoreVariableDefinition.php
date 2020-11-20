<?php

namespace App\Http\Requests;

use App\Based\Contracts\FormRequest;

class StoreVariableDefinition extends FormRequest
{
    public function rules(): array
    {
        return [
            'value' => 'required',
        ];
    }
}
