<?php

namespace App\Bundles\Vocab\Http\Requests;

use App\Bundles\Vocab\Models\VocabWord;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VocabWordRequest
 */
final class VocabWordStore extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            VocabWord::FIELD_NOMINATIVE => 'required|string',
            VocabWord::FIELD_DATIVE => 'required|string',
            VocabWord::FIELD_GENITIVE => 'required|string',
            VocabWord::FIELD_PREPOSITIONAL => 'required|string',
            VocabWord::FIELD_INSTRUMENTAL => 'required|string',
            VocabWord::FIELD_PLURAL_NOMINATIVE => 'sometimes|string',
            VocabWord::FIELD_PLURAL_DATIVE => 'sometimes|string',
            VocabWord::FIELD_PLURAL_GENITIVE => 'sometimes|string',
            VocabWord::FIELD_PLURAL_PREPOSITIONAL => 'sometimes|string',
            VocabWord::FIELD_PLURAL_INSTRUMENTAL => 'sometimes|string',
        ];
    }
}
