<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ManySuppliesRequest
 * @package App\Http\Requests
 */
class ManySuppliesRequest extends FormRequest
{
    public const FIELD_SUPPLIES = 'supplies';

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'supplies' => 'required|array',
        ];
    }
}
