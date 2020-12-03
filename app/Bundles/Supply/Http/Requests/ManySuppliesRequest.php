<?php

namespace App\Bundles\Supply\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManySuppliesRequest extends FormRequest
{
    public const FIELD_SUPPLIES = 'supplies';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            static::FIELD_SUPPLIES => 'required|array',
        ];
    }
}
