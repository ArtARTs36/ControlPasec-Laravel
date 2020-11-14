<?php

namespace App\Services\Document;

use App\Models\Document\Document;
use App\Services\Document\DocumentJoiner\AbstractDocumentJoiner;
use App\Services\Document\DocumentJoiner\PDFJoiner;

class DocumentJoinerFactory
{
    /** @var array<string> */
    const JOINERS = [
        PDFJoiner::OUTPUT_FILE_EXTENSION => PDFJoiner::class,
    ];

    /**
     * @param Document[] $documents
     * @return bool
     */
    public static function join(array $documents)
    {
        $ext = $documents[0]->getExtensionName();

        if (($count = count($documents)) && $count > 1) {
            for ($i = 1; $i < $count; $i++) {
                if ($ext !== $documents[$i]->getExtensionName()) {
                    return false;
                }
            }
        }

        if (!isset(static::JOINERS[$ext])) {
            return false;
        }

        $joinerClass = static::JOINERS[$ext];

        /** @var AbstractDocumentJoiner $joiner */
        $joiner = new $joinerClass($documents);

        return $joiner->join();
    }
}
