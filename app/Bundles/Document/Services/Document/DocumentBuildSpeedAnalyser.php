<?php

namespace App\Services\Document;

use App\Helper\Reflector;
use App\Models\Document\Document;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DocumentBuildSpeedAnalyser
{
    const ANSWER_BUILD_NOW = 1; // Можно делать документ сейчас
    const ANSWER_BUILD_IN_QUEUE = 2; // Нужно увести документ в очередь

    /**
     * @param Document $document
     * @return int
     * @throws \ReflectionException
     */
    public static function analyse(Document $document)
    {
        $relations = Reflector::getMethodsByReturnType(Document::class, BelongsToMany::class);
        $document->load($relations);

        foreach ($relations as $relation) {
            $pagesCount = $document->$relation()->count();
            if ($pagesCount > env('DOCUMENT_NUMBER_PAGES_TO_QUEUE')) {
                return static::ANSWER_BUILD_IN_QUEUE;
            }
        }

        return static::ANSWER_BUILD_NOW;
    }
}
