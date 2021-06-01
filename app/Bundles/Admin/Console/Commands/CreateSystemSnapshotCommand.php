<?php

namespace App\Bundles\Admin\Console\Commands;

use App\Bundles\Admin\Models\SystemSnapshot;
use App\Bundles\Admin\Services\SystemSnapshotCreator;
use Illuminate\Console\Command;

class CreateSystemSnapshotCommand extends Command
{
    protected $signature = 'system:create-snapshot';

    public function handle(SystemSnapshotCreator $creator): void
    {
        $creator->create();
    }
}
