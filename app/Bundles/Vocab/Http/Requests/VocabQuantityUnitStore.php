<?php

namespace App\Bundles\Vocab\Http\Requests;

use App\Bundles\Vocab\Models\SizeOfUnit;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VocabQuantityUnitStore
 * @package App\Bundles\Vocab\Http\Requests
 */
final class VocabQuantityUnitStore extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            SizeOfUnit::FIELD_NAME => 'required|string',
            SizeOfUnit::FIELD_NAME_EN => 'required|string',
            SizeOfUnit::FIELD_SHORT_NAME => 'required|string',
            SizeOfUnit::FIELD_SHORT_NAME_EN => 'required|string',
            SizeOfUnit::FIELD_OKEI => 'required|integer',
        ];
    }
}
