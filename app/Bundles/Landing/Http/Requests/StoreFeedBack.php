<?php

namespace App\Http\Requests\Landing;

use App\Based\Contracts\FormRequest;
use App\Models\Landing\LandingFeedBack;

/**
 * @mixin LandingFeedBack
 */
class StoreFeedBack extends FormRequest
{
    public function rules(): array
    {
        return [
            'people_title' => 'required|string',
            'people_email' => 'required|string',
            'people_phone' => 'required|string',
            'message' => 'required|string',
        ];
    }
}
