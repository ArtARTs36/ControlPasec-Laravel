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

    /**
     * @param string $currency
     * @return int
     */
    public function getNominal(string $currency): int;

    /**
     * @param bool $isDateTime
     * @return \DateTime|string
     */
    public function getActualTime(bool $isDateTime);
}
