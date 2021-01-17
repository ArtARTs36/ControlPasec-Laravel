<?php

namespace App\Bundles\Plant\Http\Requests;

use App\Bundles\Plant\Models\Plant;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlant extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            Plant::FIELD_NAME => 'required|string',
            Plant::FIELD_CATEGORY_ID => 'required|int',
        ];
    }
}
