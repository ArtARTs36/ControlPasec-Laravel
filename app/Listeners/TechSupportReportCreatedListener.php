<?php

namespace App\Listeners;

use App\Events\TechSupportReportCreated;
use App\Models\User\UserNotificationType;
use App\Senders\Push\Push;
use App\Support\UserNotificator;
use Illuminate\Contracts\Queue\ShouldQueue;

class TechSupportReportCreatedListener implements ShouldQueue
{
    /**
     * @param TechSupportReportCreated $event
     * @throws \Throwable
     */
    public function handle(TechSupportReportCreated $event): void
    {
        $message = view('messages/tech_support_report_created', [
            'report' => $event->report
        ])->render();

        (new Push('Тех. поддержка: '. $event->report->id, $message))->send();

        UserNotificator::notify(UserNotificationType::TECH_SUPPORT_REPORT_CREATED, $message, $event->report);
    }
}
