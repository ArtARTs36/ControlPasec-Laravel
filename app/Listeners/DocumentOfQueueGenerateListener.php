<?php

namespace App\Listeners;

use App\Bundles\Document\Events\DocumentOfQueueGenerated;
use App\Bundles\User\Models\UserNotificationType;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;
use App\Support\UserNotificator;
use Illuminate\Contracts\Queue\ShouldQueue;

class DocumentOfQueueGenerateListener implements ShouldQueue
{
    /**
     * @param DocumentOfQueueGenerated $event
     * @throws \Throwable
     */
    public function handle(DocumentOfQueueGenerated $event): void
    {
        $message = view('messages/document_of_queue_generated', [
            'document' => $event->document(),
        ])->render();

        \app(PusherInterface::class)->push(
            new Push('Документ '. $event->document()->title . ' готов', $message)
        );

        UserNotificator::notify(UserNotificationType::DOCUMENT_OF_QUEUE_GENERATED, $message, $event->document());
    }
}
