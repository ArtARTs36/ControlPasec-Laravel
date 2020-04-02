<?php

namespace App\Services\CurrencyCourseFinder;

class CbrDailyCurrencyCourseFinder implements CurrencyCourseFinderInterface
{
    const API_BASE_URL = 'https://www.cbr-xml-daily.ru/';
    const API_CURRENT_DATE = self::API_BASE_URL . 'daily_json.js';

    /** @var float[] */
    private $courseData = null;

    /** @var string */
    private $actualTime = null;

    /**
     * CbrDailyCurrencyCourseFinder constructor.
     * @param string $date
     * @throws CurrencyCourseFinderNotDataException
     */
    public function __construct(?string $date = null)
    {
        $this->parse($date);
    }

    /**
     * @param null $date
     * @throws CurrencyCourseFinderNotDataException
     */
    private function parse($date = null)
    {
        $apiUrl = ($date === null) ? self::API_CURRENT_DATE :
            self::API_BASE_URL. "archive/{$date}/daily_json.js";

        $rawData = file_get_contents($apiUrl);
        $this->handleNotDataException($rawData === false);

        $data = json_decode($rawData, true);
        $this->handleNotDataException(
            !isset($data['Date']) || !isset($data['Valute']) || !is_array($data['Valute'])
        );

        $this->actualTime = $data['Date'];
        $this->courseData = $data['Valute'];
    }

    /**
     * @param string $currency
     * @return float
     * @throws CurrencyCourseFinderNotDataException
     */
    public function getCourse(string $currency): float
    {
        $this->handleNotDataException(
            !isset($this->courseData[$currency]) || !isset($this->courseData[$currency]['Value'])
        );

        return (float) $this->courseData[$currency]['Value'];
    }

    /**
     * @param string $currency
     * @return int
     * @throws CurrencyCourseFinderNotDataException
     */
    public function getNominal(string $currency): int
    {
        $this->handleNotDataException(
            !isset($this->courseData[$currency]) || !isset($this->courseData[$currency]['Nominal'])
        );

        return (int) $this->courseData[$currency]['Nominal'];
    }

    /**
     * @param bool $isDateTime
     * @return \DateTime|string
     * @throws \Exception
     */
    public function getActualTime(bool $isDateTime = false)
    {
        return ($isDateTime === true) ? new \DateTime($this->actualTime) : $this->actualTime;
    }

    /**
     * @param bool $condition
     * @throws CurrencyCourseFinderNotDataException
     */
    private function handleNotDataException(bool $condition)
    {
        if ($condition === true) {
            throw new CurrencyCourseFinderNotDataException('Не получены данные от cbr-xml-daily.ru');
        }
    }
}
