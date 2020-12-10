<?php

namespace App\Bundles\Supply\Http\Requests;

use App\Bundles\Supply\Models\Contract;
use Illuminate\Foundation\Http\FormRequest;

class StoreContract extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            Contract::FIELD_TITLE => 'required|string',
            Contract::FIELD_SUPPLIER_ID => 'sometimes|int',
            Contract::FIELD_CUSTOMER_ID => 'required|int',
            Contract::FIELD_PLANNED_DATE => 'sometimes|date',
            Contract::FIELD_EXECUTED_DATE => 'sometimes|date',
            Contract::FIELD_TEMPLATE_ID => 'sometimes',
        ];
    }
}
