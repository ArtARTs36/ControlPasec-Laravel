<?php

namespace App\Bundles\Document\Http\Resources;

use App\Based\Support\Archiver\Archive;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Archive
 * @extends JsonResource<Archive>
 */
class ShowArchive extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->getName(),
            'timestamp' => $this->getTimeStamp(),
            'download_url' => implode(DIRECTORY_SEPARATOR, [
                $request->getSchemeAndHttpHost(),
                'api',
                'archives',
                $this->getTimeStamp(),
                $this->getName(),
            ]),
        ];
    }
}
