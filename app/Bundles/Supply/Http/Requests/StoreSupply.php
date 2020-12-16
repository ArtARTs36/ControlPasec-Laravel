<?php

namespace App\Bundles\Supply\Http\Requests;

use App\Bundles\Supply\Models\Supply;
use Illuminate\Foundation\Http\FormRequest;

class StoreSupply extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            Supply::FIELD_PLANNED_DATE => 'required',
            Supply::FIELD_EXECUTE_DATE => 'required',
            Supply::FIELD_SUPPLIER_ID => 'sometimes|int',
        ];
    }
}
