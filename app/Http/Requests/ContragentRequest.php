<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContragentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string',
            'full_title' => 'string',
            'full_title_with_opf' => 'string',

            'inn' => 'required|integer',
            'kpp' => 'integer',

            'ogrn' => 'integer',
            'okato' => 'integer',
            'oktmo' => 'integer',

            'okved' => 'string',
            'okved_type' => 'string',

            'address' => 'string',
            'address_postal' => 'string',

            'requisites.score' => 'sometimes|string',
            'requisites.bank_id' => 'sometimes|integer',

            'status' => 'default_value:0'
        ];
    }
}
