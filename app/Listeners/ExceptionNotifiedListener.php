<?php

namespace App\Listeners;

use App\Events\ExceptionNotified;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;

class ExceptionNotifiedListener
{
    /**
     * @param ExceptionNotified $event
     * @throws \ArtARTs36\PushAllSender\Exceptions\PushException
     */
    public function handle(ExceptionNotified $event): void
    {
        $msg = "Дата: " . Carbon::now()->format('d-m-Y H:i:s') . "\n" .
                $event->exception->getMessage() . "\n" .
                $event->exception->getTraceAsString();

        \app(PusherInterface::class)->push(new Push('Произошла ошибка', $msg));
    }
}
