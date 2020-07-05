<?php

namespace App\Bundles\Vocab\Http\Requests;

use App\Bundles\Vocab\Models\SizeOfUnit;
use Dba\ControlTime\Http\Requests\AuthorizedRequest;

/**
 * Class SizeOfUnitStoreRequest
 * @package App\Bundles\Vocab\Http\Requests
 */
final class SizeOfUnitStore extends AuthorizedRequest
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
