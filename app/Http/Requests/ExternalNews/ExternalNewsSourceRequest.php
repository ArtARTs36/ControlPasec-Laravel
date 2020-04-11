<?php

namespace App\Http\Requests\ExternalNews;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ExternalNewsRequest
 * @property string $name
 * @property string $link
 */
class ExternalNewsSourceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'sometimes',
            'name' => 'required|string',
            'link' => 'required|string',
        ];
    }
}
