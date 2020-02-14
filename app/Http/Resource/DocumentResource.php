<?php

namespace App\Http\Resource;

use App\Models\Document\Document;
use App\Service\Document\DocumentService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DocumentResource
 *
 * @mixin Document
 */
class DocumentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            //'download_url' => $_SERVER['HTTP_HOST'] . DocumentService::getDownloadLink($this->id)
            'download_url' => $_SERVER['HTTP_HOST'] . '/documents/' . $this->id . '/download'
        ];
    }
}
