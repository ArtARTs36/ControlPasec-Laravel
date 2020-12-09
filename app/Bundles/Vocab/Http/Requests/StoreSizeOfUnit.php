<?php

namespace App\Bundles\Vocab\Http\Requests;

use App\Bundles\Vocab\Models\SizeOfUnit;
use Illuminate\Foundation\Http\FormRequest;

class StoreSizeOfUnit extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            SizeOfUnit::FIELD_NAME => 'required|string',
            SizeOfUnit::FIELD_OKEI => 'required|int',
        ];
    }
}
