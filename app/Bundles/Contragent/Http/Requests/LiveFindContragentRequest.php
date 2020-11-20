<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LiveFindContragentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'term' => 'required|string|max:255',
        ];
    }
}
