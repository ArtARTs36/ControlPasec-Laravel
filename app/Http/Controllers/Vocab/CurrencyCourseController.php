<?php

namespace App\Http\Controllers\Vocab;

use App\Http\Controllers\Controller;
use App\Repositories\CurrencyCourseRepository;

/**
 * Class CurrencyCourseController
 * @package App\Http\Controllers\Vocab
 */
class CurrencyCourseController extends Controller
{
    /**
     * @return array
     * @throws \Exception
     */
    public function chart(): array
    {
        $data = [
            'datasets' => [],
            'labels' => []
        ];

        foreach (CurrencyCourseRepository::last() as $course) {
            if (($date = $course->getActualDate()) && !in_array($date, $data['labels'])) {
                $data['labels'][] = $date;
            }

            $data['datasets'][$course->currency->name]['data'][] = $course->getRatio();
            $data['datasets'][$course->currency->name]['label'] = $course->currency->name;
        }

        $data['datasets'] = array_values($data['datasets']);

        return $data;
    }
}
