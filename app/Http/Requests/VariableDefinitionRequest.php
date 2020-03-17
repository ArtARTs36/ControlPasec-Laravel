<?php

namespace App\Http\Requests;

use App\Models\VariableDefinition;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VariableDefinitionRequest
 * @mixin VariableDefinition
 */
class VariableDefinitionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'value' => 'required',
        ];
    }
}
