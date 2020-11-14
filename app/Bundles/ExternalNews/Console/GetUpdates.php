<?php

namespace App\Console\Commands;

use App\Bundles\ExternalNews\Services\ExternalNewsCreator;
use Illuminate\Console\Command;

class GetUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-external-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        ExternalNewsCreator::create();
    }
}
