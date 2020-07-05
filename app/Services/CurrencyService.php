<?php

namespace App\Services;

use App\Bundles\Vocab\Models\CurrencyCourse;
use App\Bundles\Vocab\Models\VocabCurrency;
use App\Services\CurrencyCourseFinder\CurrencyCourseFinderInterface;
use Illuminate\Support\Collection;

/**
 * Class CurrencyService
 * @package App\Services
 */
class CurrencyService
{
    /**
     * @return Collection
     */
    public static function getComparedCurrencies(): Collection
    {
        return VocabCurrency::query()
            ->where('iso_short_name', '!=', VocabCurrency::ISO_RUB)
            ->get();
    }

    /**
     * @param CurrencyCourseFinderInterface $finder
     * @param Collection|null $currencies
     * @return Collection
     */
    public static function saveCourses(CurrencyCourseFinderInterface $finder, Collection $currencies = null): Collection
    {
        $courses = collect();
        foreach ($currencies ?? static::getComparedCurrencies() as $currency) {
            $course = new CurrencyCourse();
            $course->currency_id = $currency->id;
            $course->nominal = $finder->getNominal($currency->iso_short_name);
            $course->value = $finder->getCourse($currency->iso_short_name);
            $course->actual_date = $finder->getActualTime(true);

            $course->save();

            $courses->push($course);
        }

        return $courses;
    }
}
