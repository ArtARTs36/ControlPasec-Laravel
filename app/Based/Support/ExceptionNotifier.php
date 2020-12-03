<?php

namespace App\Based\Support;

use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;
use Illuminate\Support\Carbon;

class ExceptionNotifier
{
    protected $pusher;

    public function __construct(PusherInterface $pusher)
    {
        $this->pusher = $pusher;
    }

    /**
     * @throws \ArtARTs36\PushAllSender\Exceptions\PushException
     */
    public function notify(\Throwable $exception): void
    {
        $msg = "Дата: " . Carbon::now()->format('d-m-Y H:i:s') . "\n" .
            $exception->getMessage() . "\n" .
            $exception->getTraceAsString();

        $this->pusher->push(new Push('Произошла ошибка', $msg));
    }
}
