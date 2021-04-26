<?php

namespace App\Bundles\User\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

final class UserRegisterRequest extends FormRequest
{
    public const FIELD_ROLE_ID = 'role_id';

    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            User::FIELD_NAME => 'required|string',
            User::FIELD_PATRONYMIC => 'required|string',
            User::FIELD_FAMILY => 'required|string',
            self::FIELD_ROLE_ID => 'required|int',
            User::FIELD_PASSWORD => 'required|string|min:8',
            User::FIELD_EMAIL => 'required|not_exists:users,email',
        ];
    }
}
