<?php

namespace App\Console\Commands;

use App\Services\CurrencyCourseFinder\CurrencyCourseFinder;
use App\Services\CurrencyService;
use Illuminate\Console\Command;

class GetCurrencyCourseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-currency-course:now';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        CurrencyService::saveCourses(
            CurrencyCourseFinder::actualFinder()
        );
    }
}
