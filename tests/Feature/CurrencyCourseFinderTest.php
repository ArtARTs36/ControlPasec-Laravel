<?php

namespace Tests\Feature;

use App\Services\CurrencyCourseFinder\CurrencyCourseFinderInterface;
use App\Services\CurrencyCourseFinder\CurrencyCourseFinderNotDataException;
use App\Services\CurrencyCourseFinder\CbrDailyCurrencyCourseFinder;
use App\Services\CurrencyCourseFinder\CurrencyCourseFinder;
use Tests\BaseTestCase;

class CurrencyCourseFinderTest extends BaseTestCase
{
    /**
     * @throws CurrencyCourseFinderNotDataException
     */
    public function testActual()
    {
        $course = CurrencyCourseFinder::actual('USD');

        self::assertIsNumeric($course);
        self::assertIsFloat($course);
    }

    /**
     * @throws CurrencyCourseFinderNotDataException
     */
    public function testPrevious()
    {
        $randomDate = $this->getFaker()->dateTimeBetween('-1 years');
        $course = CurrencyCourseFinder::previous($randomDate, 'USD');

        self::assertIsNumeric($course);
        self::assertIsFloat($course);
    }

    public function testActualFinder()
    {
        $finder = CurrencyCourseFinder::actualFinder();

        self::assertInstanceOf(CurrencyCourseFinderInterface::class, $finder);
    }

    public function testPreviousFinder()
    {
        $randomDate = $this->getFaker()->dateTimeBetween('-1 years');
        $finder = CurrencyCourseFinder::previousFinder($randomDate);

        self::assertInstanceOf(CurrencyCourseFinderInterface::class, $finder);
    }
}
