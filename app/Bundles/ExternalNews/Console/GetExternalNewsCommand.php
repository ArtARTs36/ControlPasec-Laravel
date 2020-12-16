<?php

namespace App\Bundles\ExternalNews\Console;

use App\Bundles\ExternalNews\Services\ExternalNewsCreator;
use Illuminate\Console\Command;

final class GetExternalNewsCommand extends Command
{
    protected $signature = 'external-news:fetch';

    protected $description = 'Get news of externals sources';

    public function handle(ExternalNewsCreator $creator)
    {
        $creator->create();
    }
}
