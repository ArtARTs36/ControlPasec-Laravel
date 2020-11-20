<?php

namespace App\Http\Requests\Supply;

use App\Models\Supply\Supply;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SupplyStoreManyRequest
 * @package App\Http\Requests\Supply
 */
class SupplyStoreManyRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'items' => 'required|array',
            'items.*.'. Supply::FIELD_PLANNED_DATE => 'required',
            'items.*.'. Supply::FIELD_EXECUTE_DATE => 'sometimes',
            'items.*.'. Supply::FIELD_CUSTOMER_ID => 'required',
            'items.*.'. Supply::FIELD_SUPPLIER_ID => 'sometimes',
            'options' => 'sometimes|array',
        ];
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->get('items');
    }

    /**
     * @return array
     */
    public function getOptions(): ?array
    {
        return $this->get('options');
    }
}
