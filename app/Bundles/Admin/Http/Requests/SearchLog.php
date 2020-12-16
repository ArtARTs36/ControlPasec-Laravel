<?php

namespace App\Bundles\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class SearchLog extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'query' => 'string|required',
        ];
    }
}
