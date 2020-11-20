<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateAboutMeRequest
 * @property string $about_me
 */
class UpdateAboutMeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'about_me' => 'required|max:500',
        ];
    }
}
