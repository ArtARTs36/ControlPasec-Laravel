<?php

namespace App\Bundles\Vocab\Http\Requests;

use App\Bundles\Vocab\Models\VocabPackageType;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VocabPackageTypeStore
 * @package App\Bundles\Vocab\Http\Requests
 */
final class VocabPackageTypeStore extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            VocabPackageType::FIELD_NAME => 'required|string',
        ];
    }
}
