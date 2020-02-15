<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductTransportWaybillRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'sometimes',
            'date' => 'required',
            'order_number' => 'required',
            'supply_id' => 'required'
        ];
    }
}
