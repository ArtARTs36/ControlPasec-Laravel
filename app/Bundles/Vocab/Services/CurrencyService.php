<?php

namespace App\Bundles\Vocab\Services;

use App\Bundles\Vocab\Repositories\VocabCurrencyRepository;
use App\Bundles\Vocab\Models\CurrencyCourse;
use App\Bundles\Vocab\Models\VocabCurrency;
use ArtARTs36\CbrCourseFinder\Contracts\CourseCollection;
use ArtARTs36\CbrCourseFinder\Course;
use Illuminate\Support\Collection;

class CurrencyService
{
    private $vocabRepository;

    public function __construct(VocabCurrencyRepository $vocabRepository)
    {
        $this->vocabRepository = $vocabRepository;
    }

    public function createOfExternals(CourseCollection $courses): Collection
    {
        $created = collect();

        /** @var VocabCurrency $currency */
        foreach ($this->vocabRepository->getWithoutRuble() as $currency) {
            $external = $courses->getByIsoCode($currency->iso_short_name);

            if ($external === null) {
                continue;
            }

            $created->push($this->createOfExternal($external, $currency, $courses->getActualDate()));
        }

        return $created;
    }

    protected function createOfExternal(
        Course $external,
        VocabCurrency $currency,
        \DateTimeInterface $date
    ): CurrencyCourse {
        $course = new CurrencyCourse();
        $course->currency_id = $currency->id;
        $course->nominal = $external->getNominal();
        $course->value = $external->getValue();
        $course->actual_date = $date;

        $course->save();

        return $course;
    }
}
