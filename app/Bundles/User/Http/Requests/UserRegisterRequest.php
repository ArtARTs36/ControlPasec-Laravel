<?php

namespace App\Bundles\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserRegisterRequest
 * @property int $role_id
 */
class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'patronymic' => 'required|string',
            'family' => 'required|string',
            'role_id' => 'required|int',
            'password' => 'required|string',
            'email' => 'required|not_exists:users,email',
        ];
    }
}
