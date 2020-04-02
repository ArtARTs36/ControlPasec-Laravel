<?php

namespace App\Services\CurrencyCourseFinder;

class CurrencyCourseFinder
{
    /** @var CbrDailyCurrencyCourseFinder[] */
    private static $parsers = null;

    /**
     * @param string $currency
     * @return float
     * @throws CurrencyCourseFinderNotDataException
     */
    public static function actual(string $currency)
    {
        return self::actualFinder()->getCourse($currency);
    }

    /**
     * @param \DateTime|string $date
     * @param string $currency
     * @return float
     * @throws CurrencyCourseFinderNotDataException
     */
    public static function previous($date, string $currency)
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
     * @param \DateTime|string $date
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
