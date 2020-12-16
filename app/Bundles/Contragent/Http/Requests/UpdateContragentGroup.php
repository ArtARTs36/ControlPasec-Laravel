<?php

namespace App\Bundles\Contragent\Http\Requests;

use App\Bundles\Contragent\Models\ContragentGroup;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContragentGroup extends FormRequest
{
    public const FIELD_CONTRAGENTS = 'contragents';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ContragentGroup::FIELD_NAME => 'required|string',
            static::FIELD_CONTRAGENTS => 'sometimes|array',
        ];
    }
}
