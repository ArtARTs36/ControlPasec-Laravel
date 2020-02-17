<?php

namespace App\Services\CurrencyCourseFinder;

class CurrencyCourseFinder
{
    /** @var CbrDailyCurrencyCourseFinder[] */
    private static $parsers = null;

    /**
     * @param $currency
     * @return float
     * @throws CurrencyCourseFinderNotDataException
     */
    public static function actual($currency)
    {
        return self::actualFinder()->getCourse($currency);
    }

    /**
     * @param $date
     * @param $currency
     * @return float
     * @throws CurrencyCourseFinderNotDataException
     */
    public static function previous($date, $currency)
    {
        return self::previousFinder($date)->getCourse($currency);
    }

    /**
     * @return CbrDailyCurrencyCourseFinder
     * @throws CurrencyCourseFinderNotDataException
     */
    public static function actualFinder()
    {
        if (!isset(self::$parsers['actual'])) {
            self::$parsers['actual'] = new CbrDailyCurrencyCourseFinder();
        }

        return self::$parsers['actual'];
    }

    /**
     * @param $date
     * @return CbrDailyCurrencyCourseFinder
     * @throws CurrencyCourseFinderNotDataException
     */
    public static function previousFinder($date)
    {
        if ($date instanceof \DateTime) {
            $date = $date->format('Y/m/d');
        }

        if (!isset(self::$parsers[$date])) {
            self::$parsers[$date] = new CbrDailyCurrencyCourseFinder($date);
        }

        return self::$parsers[$date];
    }
}
