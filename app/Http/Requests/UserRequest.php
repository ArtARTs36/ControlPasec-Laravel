<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserRequest
 * @property User
 */
class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'sometimes|int',
            'name' => 'required|string',
            'patronymic' => 'required|string',
            'family' => 'required|string',
            'position' => 'sometimes|string',
            'password' => 'sometimes',
        ];
    }
}
