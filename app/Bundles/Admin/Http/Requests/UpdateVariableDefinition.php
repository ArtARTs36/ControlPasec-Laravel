<?php

namespace App\Bundles\Admin\Http\Requests;

use App\Bundles\Admin\Models\VariableDefinition;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVariableDefinition extends FormRequest
{
    public function rules(): array
    {
        return [
            VariableDefinition::FIELD_VALUE => 'required',
        ];
    }
}
