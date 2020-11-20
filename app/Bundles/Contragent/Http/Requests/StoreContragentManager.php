<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContragentManager extends FormRequest
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
