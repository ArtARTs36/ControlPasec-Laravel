<?php

use App\CurrencyCourse;
use App\Models\Vocab\VocabCurrency;
use App\Services\CurrencyCourseFinder\CbrDailyCurrencyCourseFinder;
use App\Services\CurrencyCourseFinder\CurrencyCourseFinder;
use App\Services\CurrencyCourseFinder\CurrencyCourseFinderNotDataException;

class CurrencyCourseSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        if (env('ENV_TYPE') == 'dev') {
            $this->randomData(100);
        } else {
            $this->saveDataByExternalSystems(10);
        }
    }

    /**
     * @param $backDays
     * @throws Exception
     */
    private function saveDataByExternalSystems($backDays): void
    {
        $end = new DateTime();
        $start = clone $end;
        $start->modify("-{$backDays} days");

        $interval = new DateInterval('P1D');
        $dateRange = new DatePeriod($start, $interval, $end);

        try {
            $finder = CurrencyCourseFinder::actualFinder();
            foreach ($this->getAllModels(VocabCurrency::class) as $currency) {
                if ($currency->iso_short_name == 'RUB') {
                    continue;
                }

                $this->saveExternalData($finder, $currency);
            }
        } catch (Exception $exception) {}

        foreach ($dateRange as $date) {
            try {
                $finder = CurrencyCourseFinder::previousFinder($date);
                foreach ($this->getAllModels(VocabCurrency::class) as $currency) {
                    if ($currency->iso_short_name == 'RUB') {
                        continue;
                    }

                    $this->saveExternalData($finder, $currency);
                }
            } catch (Exception $exception) {}
        }
    }

    /**
     * @param CbrDailyCurrencyCourseFinder $finder
     * @param VocabCurrency $currency
     * @throws CurrencyCourseFinderNotDataException
     */
    private function saveExternalData(CbrDailyCurrencyCourseFinder $finder, VocabCurrency $currency): void
    {
        $course = new CurrencyCourse();
        $course->currency_id = $currency->id;
        $course->nominal = $finder->getNominal($currency->iso_short_name);
        $course->value = $finder->getCourse($currency->iso_short_name);
        $course->actual_date = $finder->getActualTime(true);

        $course->save();
    }

    /**
     * @param $count
     */
    private function randomData($count): void
    {
        foreach ($this->getAllModels(VocabCurrency::class) as $currency) {
            if ($currency->iso_short_name == 'RUB') {
                continue;
            }

            for ($i = 0; $i < $count; $i++) {
                $course = new CurrencyCourse();
                $course->currency_id = $currency->id;
                $course->nominal = rand(1, 100);
                $course->value = $this->getFaker()->randomFloat(500);
                $course->actual_date = $this->getFaker()->dateTime();

                $course->save();
            }
        }
    }
}
