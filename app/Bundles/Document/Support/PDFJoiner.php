<?php

namespace App\Bundles\Document\Support;

use App\Bundles\Document\Contracts\PDFUtility;
use App\Bundles\Document\Models\Document;
use App\Services\Document\DocumentService;

class PDFJoiner
{
    protected $utility;

    public function __construct(PDFUtility $utility)
    {
        $this->utility = $utility;
    }

    public function joinByPaths(array $paths): string
    {
        return $this->utility->merge($paths, $this->selectSavePath($paths));
    }

    /**
     * @param Document[] $documents
     */
    public function join(array $documents)
    {
        return $this->joinByPaths(array_map(function (Document $document) {
            return DocumentService::getDownloadLink($document, true);
        }, $documents));
    }

    protected function selectSavePath(array $paths): string
    {
        return $paths[0] . '.merged.pdf';
    }
}
