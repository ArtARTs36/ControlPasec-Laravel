<?php

namespace App\Based\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Based\Http\Requests\FetchingCalendar;
use App\Based\Services\Calendar\Calendar;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    /**
     * Показать записи из календаря
     */
    public function showByDates(FetchingCalendar $request, Calendar $calendar): JsonResource
    {
        return new JsonResource($calendar->getByDates(
            Carbon::parse($request->get('start_date')),
            Carbon::parse($request->get('end_date'))
        ));
    }
}
