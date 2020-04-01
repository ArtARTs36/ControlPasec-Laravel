<?php

namespace App\Http\Requests\Vocab;

use App\Models\Vocab\VocabWord;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VocabWordRequest
 * @mixin VocabWord
 */
class VocabWordRequest extends FormRequest
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
