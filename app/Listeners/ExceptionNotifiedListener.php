<?php

namespace App\Listeners;

use App\Events\ExceptionNotified;
use App\Senders\Push\Push;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExceptionNotifiedListener
{
    public function handle(ExceptionNotified $event): void
    {
        (new Push('Exception', $event->exception->getMessage()))->send();
    }
}
