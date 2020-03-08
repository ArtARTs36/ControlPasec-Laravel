<?php

namespace App\Http\Requests;

use App\Models\Contragent\ContragentManager;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ContragentManagerRequest
 * @mixin ContragentManager
 */
class ContragentManagerRequest extends FormRequest
{
    public function rules()
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
