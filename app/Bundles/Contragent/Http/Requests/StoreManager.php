<?php

namespace App\Bundles\Contragent\Http\Requests;

use App\Bundles\Contragent\Models\ContragentManager;
use Illuminate\Foundation\Http\FormRequest;

class StoreManager extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ContragentManager::FIELD_NAME => 'required|string',
            ContragentManager::FIELD_PATRONYMIC => 'required|string',
            ContragentManager::FIELD_FAMILY => 'required|string',
            ContragentManager::FIELD_CONTRAGENT_ID => 'required|int',
            ContragentManager::FIELD_POST => 'sometimes|string|nullable',
        ];
    }
}
