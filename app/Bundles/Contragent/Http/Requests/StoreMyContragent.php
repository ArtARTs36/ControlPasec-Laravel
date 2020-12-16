<?php

namespace App\Bundles\Contragent\Http\Requests;

use App\Bundles\Contragent\Models\MyContragent;
use Illuminate\Foundation\Http\FormRequest;

class StoreMyContragent extends FormRequest
{
    public function rules(): array
    {
        return [
            MyContragent::FIELD_NAME => 'sometimes|string',
            MyContragent::FIELD_CONTRAGENT_ID => 'required|integer',
            MyContragent::FIELD_SIGNATURE => 'sometimes|string',
        ];
    }
}
