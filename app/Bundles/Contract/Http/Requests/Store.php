<?php

namespace App\Bundles\Contract\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'customer_id' => 'required',
            'planned_date' => 'sometimes|date',
            'executed_date' => 'sometimes|date',
            'template_id' => 'sometimes',
        ];
    }
}
