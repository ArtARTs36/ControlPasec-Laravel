<?php

namespace App\Bundles\Document\Http\Resources;

use App\Models\Document\Document;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $document_url
 * @mixin Document
 * @extends JsonResource<Document>
 */
class DocumentShowResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'download_url' => $this->getDownloadLink(),
            'title' => $this->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status_id' => $this->status,
            'status_title' => $this->getStatusText(),
        ];
    }
}
