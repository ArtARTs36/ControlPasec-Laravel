<?php

use App\Bundles\Vocab\Models\CurrencyCourse;
use App\Bundles\Vocab\Models\VocabCurrency;
use App\Services\CurrencyService;

class CurrencyCourseSeeder extends CommonSeeder
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        if (env('APP_ENV') == 'local') {
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

        /** @var \ArtARTs36\CbrCourseFinder\Contracts\Finder $finder */
        $finder = app(\ArtARTs36\CbrCourseFinder\Contracts\Finder::class);

        /** @var CurrencyService $service */
        $service = app(CurrencyService::class);

        foreach ($dateRange as $date) {
            try {
                $service->createOfExternals($finder->getOnDate($date));
            } catch (Exception $exception) {
            }
        }
    }

    /**
     * @param $count
     */
    private function randomData($count): void
    {
        foreach ($this->getAllModels(VocabCurrency::class) as $currency) {
            if ($currency->iso_short_name == VocabCurrency::ISO_RUB) {
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
