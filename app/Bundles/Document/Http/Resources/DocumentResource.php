<?php

namespace App\Bundles\Document\Http\Resources;

use App\Bundles\Document\Models\Document;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $document_url
 * @mixin Document
 * @extends JsonResource<Document>
 */
class DocumentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'download_url' => $this->getDownloadLink(),
            'status_id' => $this->status,
            'action_title' => $this->getActionTitle(),
            'action_message' => $this->getActionMessage(),
        ];
    }

    private function getActionTitle(): string
    {
        return $this->status === Document::STATUS_GENERATED ?
            "Документ {$this->title} готов" :
            $this->getStatusText();
    }

    private function getActionMessage(): string
    {
        $messages = [
            Document::STATUS_NEW => 'Документ создан',
            Document::STATUS_IN_QUEUE => 'При готовности, Вам поступит уведомление',
            Document::STATUS_GENERATED => 'Чтобы скачать нажмите на это сообщение',
        ];

        return $messages[$this->status];
    }
}
