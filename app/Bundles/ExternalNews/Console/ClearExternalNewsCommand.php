<?php

namespace App\Bundles\ExternalNews\Console;

use App\Bundles\ExternalNews\Contracts\ExternalNewsRepository;
use App\Bundles\ExternalNews\Models\ExternalNews;
use Illuminate\Console\Command;

final class ClearExternalNewsCommand extends Command
{
    protected $signature = 'external-news:clear';

    protected $description = 'Clear news of externals sources';

    public function handle(ExternalNewsRepository $news)
    {
        $this->info('Удалено новостей: '. $news->truncate());
    }
}
