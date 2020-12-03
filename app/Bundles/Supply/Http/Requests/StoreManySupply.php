<?php

namespace App\Bundles\Supply\Http\Requests;

use App\Models\Supply\Supply;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SupplyStoreManyRequest
 * @package App\Http\Requests\Supply
 */
class StoreManySupply extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => 'required|array',
            'items.*.'. Supply::FIELD_PLANNED_DATE => 'required',
            'items.*.'. Supply::FIELD_EXECUTE_DATE => 'sometimes',
            'items.*.'. Supply::FIELD_CUSTOMER_ID => 'required|int',
            'items.*.'. Supply::FIELD_SUPPLIER_ID => 'sometimes|int',
            'options' => 'sometimes|array',
        ];
    }

    public function getItems(): array
    {
        return $this->get('items');
    }

    public function getOptions(): ?array
    {
        return $this->get('options');
    }
}
