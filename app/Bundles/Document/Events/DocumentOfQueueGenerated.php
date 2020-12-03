<?php

namespace App\Bundles\Document\Events;

use App\Based\Events\Event;
use App\Models\Document\Document;

final class DocumentOfQueueGenerated extends Event
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
