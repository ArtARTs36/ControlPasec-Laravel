<?php

namespace App\Console\Commands;

use App\Collection\VocabCurrencyExternalCollection;
use App\Services\CurrencyCourseFinder\CurrencyCourseFinder;
use Illuminate\Console\Command;

class GetCurrencyCourseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-currency-course';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        VocabCurrencyExternalCollection::init()->saveCourses(
            CurrencyCourseFinder::actualFinder()
        );
    }
}
