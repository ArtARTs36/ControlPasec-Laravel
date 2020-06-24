<?php

namespace App\Listeners;

use App\Events\ExceptionNotified;
use ArtARTs36\PushAllSender\Senders\PushAllSender;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;

class ExceptionNotifiedListener
{
    public function handle(ExceptionNotified $event): void
    {
        $msg = "Дата: " . Carbon::now()->format('d-m-Y H:i:s') . "\n" .
                $event->exception->getMessage() . "\n" .
                $event->exception->getTraceAsString();

        (new Push('Произошла ошибка', $msg))->send();
    }
}
