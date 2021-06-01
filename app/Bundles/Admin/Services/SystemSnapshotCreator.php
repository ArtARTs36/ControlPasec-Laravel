<?php

namespace App\Bundles\Admin\Services;

use App\Bundles\Admin\Models\SystemSnapshot;
use ArtARTs36\SystemInfo\Contracts\System;

class SystemSnapshotCreator
{
    protected $system;

    public function __construct(System $system)
    {
        $this->system = $system;
    }

    public function create(): SystemSnapshot
    {
        $snap = $this->system->createSnapshot();
        $disk = $snap->disks->getByLikeName(env('SYSTEM_DISK'));

        return SystemSnapshot::query()->create([
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
