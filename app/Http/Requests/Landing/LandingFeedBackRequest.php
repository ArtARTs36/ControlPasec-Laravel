<?php

namespace App\Http\Requests\Landing;

use App\Models\Landing\LandingFeedBack;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LandingFeedBackRequest
 * @mixin LandingFeedBack
 */
class LandingFeedBackRequest extends FormRequest
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
