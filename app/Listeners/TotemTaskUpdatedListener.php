<?php

namespace App\Listeners;

use App\Services\Shell\ShellCommand;
use Illuminate\Contracts\Queue\ShouldQueue;
use Studio\Totem\Events\Created;
use Studio\Totem\Events\Updated;

class TotemTaskUpdatedListener implements ShouldQueue
{
    /**
     * @param Created|Updated $event
     */
    public function handle($event)
    {
        ShellCommand::getInstanceWithCd(base_path(), '', false)
            ->addParameter('sh docker-supervisor-restart-without-php.sh')
            ->execute();
    }
}
