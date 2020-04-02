<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GenerateManyTypesRequest
 * @property array $types
 */
class GenerateManyTypesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'types' => 'required',
        ];
    }
}
