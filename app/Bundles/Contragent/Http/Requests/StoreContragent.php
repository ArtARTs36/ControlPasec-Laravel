<?php

namespace App\Bundles\Contragent\Http\Requests;

use App\Bundles\Contragent\Models\Contragent;
use Illuminate\Foundation\Http\FormRequest;

class StoreContragent extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'full_title' => 'string',
            'full_title_with_opf' => 'string',

            Contragent::FIELD_INN => 'required|integer',
            'kpp' => 'sometimes',

            Contragent::FIELD_OGRN => 'sometimes',
            'okato' => 'sometimes',
            'oktmo' => 'sometimes',

            'okved' => 'sometimes',
            'okved_type' => 'sometimes',

            'address' => 'sometimes',
            'address_postal' => 'sometimes',

            'requisites.score' => 'sometimes|string',
            'requisites.bank_id' => 'sometimes|integer',
        ];
    }
}
