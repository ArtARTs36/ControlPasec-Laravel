<?php

namespace App\Bundles\Vocab\Http\Requests;

use App\Bundles\Vocab\Models\VocabGosStandard;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VocabGosStandardStore
 * @package App\Bundles\Vocab\Http\Requests
 */
final class VocabGosStandardStore extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            VocabGosStandard::FIELD_NAME => 'required|string',
            VocabGosStandard::FIELD_DESCRIPTION => 'required|string',
            VocabGosStandard::FIELD_DATE_INTRODUCTION => 'required',
            VocabGosStandard::FIELD_IS_ACTIVE => 'required',
        ];
    }
}
