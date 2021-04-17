<?php

namespace App\Bundles\Admin\Http\Resources;

use ArtARTs36\SystemInfo\Entities\Snapshot;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Snapshot
 */
class SnapshotResource extends JsonResource
{
    public function toArray($request): array
    {
        $disk = $this->disks->getByLikeName(env('SYSTEM_DISK'));

        return [
            'date' => $this->date,
            'cpu'  => [
                'user' => $this->cpu->userUsage,
                'system' => $this->cpu->systemUsage,
                'idle' => $this->cpu->idle,
            ],
            'memory' => $disk ? [
                'available' => $disk->memory->availableGb,
                'used' => $disk->memory->usedGb,
                'total' => $disk->memory->totalGb,
            ] : null,
        ];
    }
}
