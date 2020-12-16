<?php

namespace App\Bundles\Document\Support;

use App\Bundles\User\Models\UserNotificationType;
use App\Bundles\Document\Models\Document;
use App\Bundles\User\Support\UserMessageNotifier;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;

class DocumentNotifier
{
    protected $pusher;

    protected $userNotifier;

    public function __construct(PusherInterface $pusher, UserMessageNotifier $userNotifier)
    {
        $this->pusher = $pusher;
        $this->userNotifier = $userNotifier;
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

        $this->userNotifier->notify(UserNotificationType::DOCUMENT_OF_QUEUE_GENERATED, $message, $document);
    }
}
