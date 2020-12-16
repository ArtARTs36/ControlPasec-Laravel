<?php

namespace App\Bundles\User\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AuthRequest
 * @property string $email
 * @property string $password
 */
class AuthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            User::FIELD_EMAIL => 'required|string|email',
            User::FIELD_PASSWORD => 'required|string',
        ];
    }
}
