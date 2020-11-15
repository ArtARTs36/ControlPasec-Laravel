<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContragentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'full_title' => 'string',
            'full_title_with_opf' => 'string',

            'inn' => 'required|integer',
            'kpp' => 'sometimes',

            'ogrn' => 'sometimes',
            'okato' => 'sometimes',
            'oktmo' => 'sometimes',

            'okved' => 'sometimes',
            'okved_type' => 'sometimes',

            'address' => 'sometimes',
            'address_postal' => 'sometimes',

            'requisites.score' => 'sometimes|string',
            'requisites.bank_id' => 'sometimes|integer',

            //'status' => 'default_value:0'
        ];
    }
}
