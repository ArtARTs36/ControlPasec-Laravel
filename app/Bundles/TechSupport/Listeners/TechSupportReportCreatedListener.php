<?php

namespace App\Bundles\TechSupport\Listeners;

use App\Events\TechSupportReportCreated;
use App\Models\User\UserNotificationType;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;
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

        \app(PusherInterface::class)->push(new Push('Тех. поддержка: '. $event->report->id, $message));

        UserNotificator::notify(UserNotificationType::TECH_SUPPORT_REPORT_CREATED, $message, $event->report);
    }
}
