<?php

namespace App\Bundles\TechSupport\Listeners;

use App\Bundles\TechSupport\Events\ReportCreated;
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
    public function handle(ReportCreated $event): void
    {
        $message = view('messages/tech_support_report_created', [
            'report' => $event->getReport(),
        ])->render();

        $this->pusher->push(new Push('Тех. поддержка: '. $event->getReport()->id, $message));

        UserNotificator::notify(UserNotificationType::TECH_SUPPORT_REPORT_CREATED, $message, $event->getReport());
    }
}
