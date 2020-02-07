<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ContractRequest
 */
class ContractRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'supplier_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'planned_date' => 'sometimes|date',
            'executed_date' => 'sometimes|date',
        ];
    }
}
