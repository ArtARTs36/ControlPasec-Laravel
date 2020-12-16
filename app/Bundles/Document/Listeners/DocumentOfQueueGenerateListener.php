<?php

namespace App\Bundles\Document\Listeners;

use App\Bundles\Document\Events\DocumentOfQueueGenerated;
use App\Bundles\Document\Support\DocumentNotifier;
use Illuminate\Contracts\Queue\ShouldQueue;

final class DocumentOfQueueGenerateListener implements ShouldQueue
{
    private $notifier;

    public function __construct(DocumentNotifier $notifier)
    {
        $this->notifier = $notifier;
    }

    /**
     * @throws \Throwable
     */
    public function handle(DocumentOfQueueGenerated $event): void
    {
        $this->notifier->notify($event->document());
    }
}
