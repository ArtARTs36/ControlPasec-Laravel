<?php

namespace App\Bundles\Admin\Services;

use App\Bundles\Admin\Models\SystemSnapshot;
use App\Bundles\Admin\Repositories\SystemSnapshotRepository;
use ArtARTs36\SystemInfo\Contracts\System;

class SystemSnapshotCreator
{
    protected $system;

    protected $snapshots;

    public function __construct(System $system, SystemSnapshotRepository $snapshots)
    {
        $this->system = $system;
        $this->snapshots = $snapshots;
    }

    public function create(): SystemSnapshot
    {
        $snap = $this->system->createSnapshot();
        $disk = $snap->disks->getByLikeName(env('SYSTEM_DISK'));

        return $this->snapshots->createFromAttributes([
            SystemSnapshot::FIELD_DISK_NAME => $disk->name,
            SystemSnapshot::FIELD_DISK_TOTAL => $disk->memory->totalGb,
            SystemSnapshot::FIELD_DISK_AVAILABLE => $disk->memory->availableGb,
            SystemSnapshot::FIELD_DISK_USED => $disk->memory->usedGb,
            SystemSnapshot::FIELD_CPU_IDLE => $snap->cpu->idle,
            SystemSnapshot::FIELD_CPU_SYSTEM_USAGE => $snap->cpu->systemUsage,
            SystemSnapshot::FIELD_CPU_USER_USAGE => $snap->cpu->userUsage,
            SystemSnapshot::CREATED_AT => $snap->date,
        ]);
    }
}
