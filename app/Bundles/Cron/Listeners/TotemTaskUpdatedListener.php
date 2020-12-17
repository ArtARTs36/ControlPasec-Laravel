<?php

namespace App\Bundles\Cron\Listeners;

use App\Based\Support\Supervisor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;
use Studio\Totem\Events\Created;
use Studio\Totem\Events\Deleted;
use Studio\Totem\Events\Updated;

class TotemTaskUpdatedListener implements ShouldQueue
{
    protected $supervisor;

    public function __construct(Supervisor $supervisor)
    {
        $this->supervisor = $supervisor;
    }

    /**
     * @param Created|Updated|Deleted $event
     */
    public function handle($event)
    {
        Artisan::queue('cache:clear');

        $this->supervisor->update();
    }
}
