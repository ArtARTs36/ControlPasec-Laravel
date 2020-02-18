<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplyProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'quantity' => 'required',
            'price' => 'required',
            'product_id' => 'required|integer',
            'quantity_unit_id' => 'required',
        ];
    }
}
