<?php

namespace App\Bundles\Document\Events;

use App\Events\BaseEvent;
use App\Models\Document\Document;

final class DocumentOfQueueGenerated extends BaseEvent
{
    private $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function document(): Document
    {
        return $this->document;
    }
}
