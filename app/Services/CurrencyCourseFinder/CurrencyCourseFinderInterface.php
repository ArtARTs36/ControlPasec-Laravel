<?php

namespace App\Services\CurrencyCourseFinder;

/**
 * Interface CurrencyCourseFinderInterface
 */
interface CurrencyCourseFinderInterface
{
    /**
     * @param string $currency
     * @return float
     */
    public function getCourse(string $currency): float;
}
