<?php

namespace App\Bundles\Vocab\Console;

use App\Bundles\Vocab\Models\CurrencyCourse;
use Illuminate\Console\Command;

/**
 * Команда для удаления все курсов валют
 */
final class ClearCurrencyCoursesCommand extends Command
{
    protected $signature = 'currency-course:clear';

    protected $description = 'Remove all currency courses';

    public function handle()
    {
        CurrencyCourse::query()->truncate();

        $this->info('Курсы валют успешно очищены!');
    }
}
