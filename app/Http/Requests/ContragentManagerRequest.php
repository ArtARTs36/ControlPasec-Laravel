<?php

namespace App\Http\Requests;

use App\Models\Contragent\ContragentManager;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @mixin ContragentManager
 */
class ContragentManagerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'patronymic' => 'required',
            'family' => 'required',
            'contragent_id' => 'required',
            'post' => 'sometimes',
        ];
    }
}
