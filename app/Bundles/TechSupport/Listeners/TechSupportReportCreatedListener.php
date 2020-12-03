<?php

namespace App\Bundles\TechSupport\Listeners;

use App\Events\TechSupportReportCreated;
use App\Bundles\User\Models\UserNotificationType;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;
use App\Support\UserNotificator;
use Illuminate\Contracts\Queue\ShouldQueue;

final class TechSupportReportCreatedListener implements ShouldQueue
{
    private $pusher;

    public function __construct(PusherInterface $pusher)
    {
        $this->pusher = $pusher;
    }

    /**
     * @throws \Throwable
     */
    public function handle(TechSupportReportCreated $event): void
    {
        $message = view('messages/tech_support_report_created', [
            'report' => $event->report
        ])->render();

        $this->pusher->push(new Push('Тех. поддержка: '. $event->report->id, $message));

        UserNotificator::notify(UserNotificationType::TECH_SUPPORT_REPORT_CREATED, $message, $event->report);
    }
}
