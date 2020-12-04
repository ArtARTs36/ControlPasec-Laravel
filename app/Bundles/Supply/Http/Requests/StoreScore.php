<?php

namespace App\Bundles\Supply\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScore extends FormRequest
{
    public function rules(): array
    {
        return [
            'supply_id' => 'required|integer',
            'contract_id' => 'sometimes',
            'date' => 'required|string',
            'order_number' => 'sometimes',
        ];
    }
}
