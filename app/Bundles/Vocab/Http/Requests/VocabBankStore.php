<?php

namespace App\Bundles\Vocab\Http\Requests;

use App\Bundles\Vocab\Models\VocabBank;
use Dba\ControlTime\Http\Requests\AuthorizedRequest;

/**
 * Class VocabBankStoreRequest
 * @package App\Bundles\Vocab\Http\Requests
 */
final class VocabBankStore extends AuthorizedRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            VocabBank::FIELD_SHORT_NAME => 'required|string',
            VocabBank::FIELD_FULL_NAME => 'required|string',
            VocabBank::FIELD_SCORE => 'required|string',
            VocabBank::FIELD_BIK => 'required|integer',
        ];
    }
}
