<?php

namespace App\Bundles\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DialogMessageRequest
 * @property int $to_user_id
 * @property string $text
 */
class StoreMessage extends FormRequest
{
    public function rules(): array
    {
        return [
            'to_user_id' => 'required|integer|exists:users,id',
            'text' => 'required|string',
        ];
    }
}
