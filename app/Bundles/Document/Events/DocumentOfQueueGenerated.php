<?php

namespace App\Events;

use App\Models\Document\Document;

class DocumentOfQueueGenerated extends Event
{
    public $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }
}
