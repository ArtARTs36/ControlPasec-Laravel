<?php

namespace App\Http\Resource;

use App\Models\TechSupport\TechSupportReport;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TechSupportReportResource
 * @mixin TechSupportReport
 * @extends JsonResource<TechSupportReport>
 */
class TechSupportReportResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'author_full_name' => $this->getAuthorFullName(),
            TechSupportReport::FIELD_MESSAGE => $this->message,
            TechSupportReport::FIELD_IP => $this->ip,
            TechSupportReport::RELATION_USER => $this->user,
            'created_at' => Carbon::parse($this->created_at)->format($format = 'Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format($format),
            'is_read' => $this->is_read,
        ];
    }
}
