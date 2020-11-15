<?php

namespace App\Http\Requests\Contragent;

use App\Models\Contragent\ContragentGroup;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ContragentGroupUpdateRequest
 * @package App\Http\Requests\Contragent
 */
class ContragentGroupUpdateRequest extends FormRequest
{
    public const FIELD_CONTRAGENTS = 'contragents';

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
            ContragentGroup::FIELD_NAME => 'required|string',
            static::FIELD_CONTRAGENTS => 'sometimes|array',
        ];
    }
}
