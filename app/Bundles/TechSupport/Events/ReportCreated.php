<?php

namespace App\Bundles\TechSupport\Events;

use App\Bundles\TechSupport\Models\TechSupportReport;
use App\Events\BaseEvent;

final class ReportCreated extends BaseEvent
{
    private $report;

    public function __construct(TechSupportReport $report)
    {
        $this->report = $report;
    }

    public function getReport(): TechSupportReport
    {
        return $this->report;
    }
}
