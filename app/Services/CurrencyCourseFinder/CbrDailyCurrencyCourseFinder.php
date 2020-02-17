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
     * @param null $date
     * @throws CurrencyCourseFinderNotDataException
     */
    public function __construct($date = null)
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
     * @param bool $isDateTime
     * @return \DateTime|null
     * @throws \Exception
     */
    public function getActualTime($isDateTime = false)
    {
        return ($isDateTime === true) ? new \DateTime($this->actualTime) : $this->actualTime;
    }

    /**
     * @param $condition
     * @throws CurrencyCourseFinderNotDataException
     */
    private function handleNotDataException($condition)
    {
        if ($condition === true) {
            throw new CurrencyCourseFinderNotDataException('Не получены данные от cbr-xml-daily.ru');
        }
    }
}
