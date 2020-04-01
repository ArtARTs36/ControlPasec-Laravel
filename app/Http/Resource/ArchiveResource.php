<?php

namespace App\Http\Resource;

use App\Support\Archiver\Archive;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ArchiveResource
 * @mixin Archive
 */
class ArchiveResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->getName(),
            'timestamp' => $this->getTimeStamp(),
        ];
    }
}
