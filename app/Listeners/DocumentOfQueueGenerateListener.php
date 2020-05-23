<?php

namespace App\Listeners;

use App\Events\DocumentOfQueueGenerated;
use App\Events\LandingFeedBackCreated;
use App\Models\User\UserNotificationType;
use App\Senders\PushAllSender;
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
        $sender = new PushAllSender();

        $message = view('messages/document_of_queue_generated', [
            'document' => $event->document,
        ])->render();

        $sender->push('Документ '. $event->document->title . ' готов', $message);

        UserNotificator::notify(UserNotificationType::DOCUMENT_OF_QUEUE_GENERATED, $message, $event->document);
    }
}
