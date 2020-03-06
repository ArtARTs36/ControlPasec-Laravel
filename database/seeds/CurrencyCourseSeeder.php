<?php

use App\Collection\VocabCurrencyExternalCollection;
use App\CurrencyCourse;
use App\Models\Vocab\VocabCurrency;
use App\Services\CurrencyCourseFinder\CurrencyCourseFinder;

class CurrencyCourseSeeder extends CommonSeeder
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
            VocabCurrencyExternalCollection::init()->saveCourses($finder);
        } catch (Exception $exception) {}

        foreach ($dateRange as $date) {
            try {
                $finder = CurrencyCourseFinder::previousFinder($date);
                VocabCurrencyExternalCollection::init()->saveCourses($finder);
            } catch (Exception $exception) {}
        }
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
                $course->value = $this->faker()->randomFloat(500);
                $course->actual_date = $this->faker()->dateTime();

                $course->save();
            }
        }
    }
}
