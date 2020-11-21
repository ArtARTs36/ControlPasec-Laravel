<?php

namespace App\Services;

use App\Bundles\Vocab\Models\CurrencyCourse;
use App\Bundles\Vocab\Models\VocabCurrency;
use ArtARTs36\CbrCourseFinder\Contracts\CourseCollection;
use ArtARTs36\CbrCourseFinder\Course;
use Illuminate\Support\Collection;

/**
 * Class CurrencyService
 * @package App\Services
 */
class CurrencyService
{
    public function getComparedCurrencies(): Collection
    {
        return VocabCurrency::query()
            ->where('iso_short_name', '!=', VocabCurrency::ISO_RUB)
            ->get();
    }

    public function createOfExternals(CourseCollection $courses): Collection
    {
        $created = collect();

        /** @var VocabCurrency $currency */
        foreach (static::getComparedCurrencies() as $currency) {
            $external = $courses->getByIsoCode($currency->iso_short_name);

            if ($external === null) {
                continue;
            }

            $created->push($this->createOfExternal($external, $currency, $courses->getActualDate()));
        }

        return $created;
    }

    protected function createOfExternal(Course $external, VocabCurrency $currency, \DateTimeInterface $date)
    {
        $course = new CurrencyCourse();
        $course->currency_id = $currency->id;
        $course->nominal = $external->getNominal();
        $course->value = $external->getValue();
        $course->actual_date = $date;

        $course->save();

        return $course;
    }
}
