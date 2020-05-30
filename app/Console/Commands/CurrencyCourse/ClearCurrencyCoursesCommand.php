<?php

namespace App\Console\Commands\CurrencyCourse;

use App\Collection\VocabCurrencyExternalCollection;
use App\CurrencyCourse;
use App\Services\CurrencyCourseFinder\CurrencyCourseFinder;
use Illuminate\Console\Command;

class ClearCurrencyCoursesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-currency-course:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        CurrencyCourse::query()->truncate();
    }
}
