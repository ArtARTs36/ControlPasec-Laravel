<?php

namespace App\Bundles\User\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Запрос на создание учетной записи пользователя
 */
class StoreUser extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /** @todo зачем */
            'id' => 'sometimes|int',
            User::FIELD_NAME => 'required|string|max:255',
            User::FIELD_PATRONYMIC => 'required|string|max:255',
            User::FIELD_FAMILY => 'required|string|max:255',
            User::FIELD_POSITION => 'sometimes|string|max:255',
            User::FIELD_PASSWORD => 'sometimes|max:255',
            User::FIELD_IS_ACTIVE => 'sometimes|bool',
            User::FIELD_EMAIL => 'required|email',
        ];
    }
}
