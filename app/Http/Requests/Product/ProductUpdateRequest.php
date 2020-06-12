<?php

namespace App\Http\Requests\Product;

use App\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProductUpdateRequest
 * @package App\Http\Requests\Product
 */
class ProductUpdateRequest extends FormRequest
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
            Product::FIELD_NAME => 'string|required',
            Product::FIELD_NAME_FOR_DOCUMENT => 'string|required',
            Product::FIELD_SIZE => 'required',
            Product::FIELD_SIZE_OF_UNIT_ID => 'required|integer',
            Product::FIELD_PRICE => 'required',
            Product::FIELD_CURRENCY_ID => 'required|integer',
            Product::FIELD_QUANTITY_UNIT_ID => 'sometimes|integer',
            Product::FIELD_PACKAGE_TYPE_ID => 'required|integer',
            Product::FIELD_GOS_STANDARD_ID => 'required|integer',
        ];
    }
}
