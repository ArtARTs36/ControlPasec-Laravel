<?php

namespace App\Bundles\Landing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedBack extends FormRequest
{
    public function rules(): array
    {
        return [
            'people_title' => 'required|string',
            'people_email' => 'required|string',
            'people_phone' => 'required|string',
            'message' => 'required|string',
        ];
    }
}
