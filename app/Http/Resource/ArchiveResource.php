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
            'title' => $this->getName(),
            'timestamp' => $this->getTimeStamp(),
            'download_url' => $_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, [
                'api',
                'archives',
                $this->getTimeStamp(),
                $this->getName(),
            ]),
        ];
    }
}
