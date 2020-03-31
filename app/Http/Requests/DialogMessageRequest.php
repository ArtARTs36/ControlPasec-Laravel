<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DialogMessageRequest
 * @property int to_user_id
 * @property string text
 */
class DialogMessageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'to_user_id' => 'required|integer|exists:users,id',
            'text' => 'required|string',
        ];
    }
}
