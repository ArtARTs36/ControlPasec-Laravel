<?php

namespace App\Bundles\Document\Support;

use App\Bundles\User\Models\UserNotificationType;
use App\Models\Document\Document;
use App\Support\UserNotificator;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;

class DocumentNotifier
{
    protected $pusher;

    public function __construct(PusherInterface $pusher)
    {
        $this->pusher = $pusher;
    }

    /**
     * @throws \ArtARTs36\PushAllSender\Exceptions\PushException
     * @throws \Throwable
     */
    public function notify(Document $document): void
    {
        $message = view('messages/document_of_queue_generated', [
            'document' => $document,
        ])->render();

        $this->pusher->push(
            new Push('Документ '. $document->title . ' готов', $message)
        );

        UserNotificator::notify(UserNotificationType::DOCUMENT_OF_QUEUE_GENERATED, $message, $document);
    }
}
