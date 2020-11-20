<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MyContragentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|string',
            'contragent_id' => 'required|integer'
        ];
    }
}
