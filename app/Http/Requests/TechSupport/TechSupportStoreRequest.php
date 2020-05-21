<?php

namespace App\Http\Requests\TechSupport;

use App\Models\TechSupport\TechSupportReport;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TechSupportStoreRequest
 * @package App\Http\Requests\TechSupport
 */
class TechSupportStoreRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            TechSupportReport::FIELD_MESSAGE => 'required|string',
        ];

        if (auth()->user() === null) {
            $rules = array_merge($rules, [
                TechSupportReport::FIELD_AUTHOR_TITLE => 'required|string',
                TechSupportReport::FIELD_AUTHOR_CONTACT => 'required|string',
            ]);
        }

        return $rules;
    }
}
