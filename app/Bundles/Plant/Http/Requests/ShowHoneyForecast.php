<?php

namespace App\Bundles\Plant\Http\Requests;

use ArtARTs36\ControlTime\Contracts\FormRequest;

class ShowHoneyForecast extends FormRequest
{
    public const FIELD_PLANT_ID = 'plant_id';
    public const FIELD_DATE_START = 'date_start';
    public const FIELD_DATE_END = 'date_end';
    public const FIELD_BEES = 'bees';
    public const FIELD_SQUARE = 'square';

    public function rules(): array
    {
        return [
            'plant_id' => 'required|integer',
            'date_start' => 'required|string',
            'date_end' => 'required|string',
            'bees' => 'required|integer',
            'square' => 'required|integer',
        ];
    }
}
