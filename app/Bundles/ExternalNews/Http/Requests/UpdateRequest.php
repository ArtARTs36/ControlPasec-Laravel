<?php

namespace App\Bundles\ExternalNews\Http\Requests;

use App\Bundles\ExternalNews\Models\ExternalNews;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateRequest
 * @package App\Bundles\ExternalNews\Http\Requests
 */
final class UpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ExternalNews::FIELD_TITLE => 'required|string',
            ExternalNews::FIELD_DESCRIPTION => 'required|string',
        ];
    }
}
