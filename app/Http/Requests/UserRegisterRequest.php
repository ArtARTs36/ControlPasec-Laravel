<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserRegisterRequest
 * @property int role_id
 * @mixin User
 */
class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !auth()->check();
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
