<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SupplyRequest
 * @package App\Http\Requests
 */
class SupplyRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'planned_date' => 'required',
            'execute_date' => 'required'
        ];
    }
}
