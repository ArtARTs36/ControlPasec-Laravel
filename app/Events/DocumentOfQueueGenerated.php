<?php

namespace App\Events;

use App\Models\Document\Document;

class DocumentOfQueueGenerated extends BaseEvent
{
    public $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }
}
