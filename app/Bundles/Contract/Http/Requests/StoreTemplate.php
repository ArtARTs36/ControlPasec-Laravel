<?php

namespace App\Bundles\Contract\Http\Requests;

use App\Bundles\Contract\Models\ContractTemplate;
use Illuminate\Foundation\Http\FormRequest;

class StoreTemplate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ContractTemplate::FIELD_TITLE => 'required|string',
            ContractTemplate::FIELD_NAME => 'required|string',
        ];
    }
}
