<?php

namespace App\Support\Log;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LogSearchRequest
 * @package App\Support\Log
 */
final class LogSearchRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'query' => 'string|required',
        ];
    }
}
