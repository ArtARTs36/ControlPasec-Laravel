<?php

namespace App\Bundles\ExternalNews\Console;

use App\Bundles\ExternalNews\Services\ExternalNewsCreator;
use Illuminate\Console\Command;

final class GetExternalNewsCommand extends Command
{
    protected $signature = 'get-external-news';

    protected $description = 'Command description';

    public function handle()
    {
        app(ExternalNewsCreator::class)->create();
    }
}
