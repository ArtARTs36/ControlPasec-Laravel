<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScoreForPaymentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'supply_id' => 'required|integer',
            'contract_id' => 'required|integer',
            'date' => 'required|string',
        ];
    }
}
