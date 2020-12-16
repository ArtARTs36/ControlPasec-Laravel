<?php

namespace App\Based\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FetchingCalendar extends FormRequest
{
    public function rules(): array
    {
        return [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }
}
