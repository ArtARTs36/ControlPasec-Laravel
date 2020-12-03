<?php

namespace App\Bundles\Supply\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplyProduct extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'required',
            'price' => 'required',
            'product_id' => 'required|integer',
            'quantity_unit_id' => 'required',
        ];
    }
}
