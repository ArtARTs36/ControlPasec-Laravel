<?php

namespace App\Bundles\Vocab\Http\Requests;

use App\Models\Vocab\SizeOfUnit;
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
