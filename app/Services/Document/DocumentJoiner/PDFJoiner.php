<?php

namespace App\Services\Document\DocumentJoiner;

use App\Bundles\Document\Support\PdfCpu;

/**
 * @todo переделать
 */
class PDFJoiner extends AbstractDocumentJoiner
{
    const OUTPUT_FILE_EXTENSION = 'pdf';

    public function join()
    {
        $pdfCpu = new PdfCpu();
        $pdfCpu->merge($this->filesPaths, $this->savePath);

        return file_exists($this->savePath) ? $this->savePath : false;
    }
}
