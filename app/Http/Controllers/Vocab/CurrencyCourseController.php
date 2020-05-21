<?php

namespace App\Http\Controllers\Vocab;

use App\CurrencyCourse;
use App\Http\Controllers\Controller;

class CurrencyCourseController extends Controller
{
    public function chart()
    {
        $courses = CurrencyCourse::with('currency')
            ->orderBy(CurrencyCourse::FIELD_ACTUAL_DATE, 'desc')
            ->take(100)
            ->get();

        $data = [
            'datasets' => [],
            'labels' => []
        ];

        /** @var CurrencyCourse $course */
        foreach ($courses as $course) {
            $dateTime = new \DateTime($course->actual_date);
            $date = $dateTime->format('d.m.Y');

            if (!in_array($date, $data['labels'])) {
                $data['labels'][] = $date;
            }

            $data['datasets'][$course->currency->name]['data'][] = $course->value / $course->nominal;
            $data['datasets'][$course->currency->name]['label'] = $course->currency->name;
        }

        $data['datasets'] = array_values($data['datasets']);

        return $data;
    }
}
