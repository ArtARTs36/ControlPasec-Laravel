<?php

namespace App\Bundles\Supply\Http\Requests;

use ArtARTs36\ControlTime\Contracts\FormRequest;

class SupplyTransitionRequest extends FormRequest
{
    public const FIELD_COMMENT = 'comment';

    public function rules(): array
    {
        return [
            static::FIELD_COMMENT => 'string|required',
        ];
    }
}
