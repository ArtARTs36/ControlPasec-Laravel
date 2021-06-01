<?php

namespace App\Bundles\Admin\Http\Resources;

use App\Bundles\Admin\Models\SystemSnapshot;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SystemSnapshot
 */
class SavedSnapshotResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'date' => $this->created_at,
            'cpu'  => [
                'user' => $this->cpu_user_usage,
                'system' => $this->cpu_system_usage,
                'idle' => $this->cpu_idle,
            ],
            'memory' => [
                'available' => $this->disk_available,
                'used' => $this->disk_used,
                'total' => $this->disk_total,
            ],
        ];
    }
}
