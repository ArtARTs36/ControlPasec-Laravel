<?php

namespace App\Collection;

use App\Models\Vocab\CurrencyCourse;
use App\Models\Vocab\VocabCurrency;
use App\Services\CurrencyCourseFinder\CurrencyCourseFinderInterface;

class VocabCurrencyExternalCollection implements \Iterator
{
    /** @var int */
    private $position;

    /**
     * @var VocabCurrency[]|array
     */
    private static $currencies;

    /**
     * VocabCurrencyExternalCollection constructor.
     * @param VocabCurrency[] $currencies
     */
    public function __construct(array $currencies = null)
    {
        if ($currencies === null) {
            $currencies = VocabCurrency::all()->getDictionary();
        }

        if ($currencies !== null) {
            self::$currencies = array_values(array_filter($currencies, function (VocabCurrency $currency) {
                return $currency->iso_short_name !== 'RUB';
            }));
        }

        $this->position = 0;
    }

    public static function init(): self
    {
        return new static();
    }

    public function current()
    {
        return self::$currencies[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset(self::$currencies[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @param CurrencyCourseFinderInterface $finder
     * @return array
     */
    public function saveCourses(CurrencyCourseFinderInterface $finder)
    {
        $courses = [];
        foreach (self::$currencies as $currency) {
            $course = new CurrencyCourse();
            $course->currency_id = $currency->id;
            $course->nominal = $finder->getNominal($currency->iso_short_name);
            $course->value = $finder->getCourse($currency->iso_short_name);
            $course->actual_date = $finder->getActualTime(true);

            $course->save();

            $courses[] = $course;
        }

        return $courses;
    }
}
