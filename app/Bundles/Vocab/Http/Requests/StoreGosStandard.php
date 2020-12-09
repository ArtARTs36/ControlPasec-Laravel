<?php

namespace App\Bundles\Vocab\Http\Requests;

use App\Bundles\Vocab\Models\VocabGosStandard;
use Illuminate\Foundation\Http\FormRequest;

class StoreGosStandard extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            VocabGosStandard::FIELD_NAME => 'required|string',
            VocabGosStandard::FIELD_DESCRIPTION => 'required|string',
            VocabGosStandard::FIELD_IS_ACTIVE => 'boolean',
            VocabGosStandard::FIELD_DATE_INTRODUCTION => 'string',
        ];
    }
}
