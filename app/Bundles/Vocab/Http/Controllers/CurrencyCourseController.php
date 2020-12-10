<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Repositories\CurrencyCourseRepository;
use App\Based\Contracts\Controller;

final class CurrencyCourseController extends Controller
{
    private $repository;

    public function __construct(CurrencyCourseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws \Exception
     */
    public function chart(): array
    {
        $data = [
            'datasets' => [],
            'labels' => []
        ];

        foreach ($this->repository->last() as $course) {
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
