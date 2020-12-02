<?php

namespace App\Bundles\Vocab\Console;

use App\Bundles\Vocab\Models\CurrencyCourse;
use Illuminate\Console\Command;

/**
 * Команда для удаления все курсов валют
 */
final class ClearCurrencyCoursesCommand extends Command
{
    protected $signature = 'get-currency-course:clear';

    protected $description = 'Command description';

    public function handle()
    {
        CurrencyCourse::query()->truncate();
    }
}
