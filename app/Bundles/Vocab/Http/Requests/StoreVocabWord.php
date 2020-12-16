<?php

namespace App\Bundles\Vocab\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVocabWord extends FormRequest
{
    public function rules(): array
    {
        return [
            'nominative' => 'required|string',
            'dative' => 'required|string',
            'genitive' => 'required|string',
            'prepositional' => 'required|string',
            'instrumental' => 'required|string',
            'plural_nominative' => 'sometimes|string',
            'plural_dative' => 'sometimes|string',
            'plural_genitive' => 'sometimes|string',
            'plural_prepositional' => 'sometimes|string',
            'plural_instrumental' => 'sometimes|string',
        ];
    }
}
