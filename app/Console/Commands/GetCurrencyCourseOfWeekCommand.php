<?php

namespace App\Console\Commands;

use App\Services\CurrencyCourseFinder\CurrencyCourseFinder;
use App\Services\CurrencyService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetCurrencyCourseOfWeekCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-currency-course:week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::parse("-{$i} days");

            try {
                CurrencyService::saveCourses(
                    CurrencyCourseFinder::previousFinder($date)
                );
            } catch (\Exception $exception) {
                $this->warn($exception->getMessage());
            }
        }
    }
}
