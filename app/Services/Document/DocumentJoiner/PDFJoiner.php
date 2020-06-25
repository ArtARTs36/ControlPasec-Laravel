<?php

namespace App\Services\Document\DocumentJoiner;

use App\Services\Go\PdfCpuGoProgram;

class PDFJoiner extends AbstractDocumentJoiner
{
    const OUTPUT_FILE_EXTENSION = 'pdf';

    public function join()
    {
        $pdfCpu = new PdfCpuGoProgram();
        $pdfCpu->merge($this->filesPaths, $this->savePath);

        return file_exists($this->savePath) ? $this->savePath : false;
    }
}
