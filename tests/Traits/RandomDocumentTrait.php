<?php

namespace Tests\Traits;

use App\Models\Document\Document;

trait RandomDocumentTrait
{
    private function getRandomDocumentByType($type)
    {
        return Document::where('type_id', $type)
            ->inRandomOrder()
            ->get()
            ->first();
    }
}
