<?php

namespace App\Bundles\Vocab\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVocabPackageType extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }
}
