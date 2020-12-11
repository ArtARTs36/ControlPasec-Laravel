<?php

namespace App\Bundles\Supply\Http\Requests;

use App\Bundles\Supply\Models\ProductTransportWaybill;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductTransportWaybill extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ProductTransportWaybill::FIELD_DATE => 'required',
            ProductTransportWaybill::FIELD_SUPPLY_ID => 'required',
            ProductTransportWaybill::FIELD_ORDER_NUMBER => 'required'
        ];
    }
}
