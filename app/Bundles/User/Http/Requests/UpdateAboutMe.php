<?php

namespace App\Bundles\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class UpdateAboutMeRequest
 * @property string $about_me
 */
class UpdateAboutMe extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'about_me' => 'required|max:500',
        ];
    }
}
