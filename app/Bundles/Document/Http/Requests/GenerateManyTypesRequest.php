<?php

namespace App\Bundles\Document\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GenerateManyTypesRequest
 * @property array $types
 */
class GenerateManyTypesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'types' => 'required',
        ];
    }
}
