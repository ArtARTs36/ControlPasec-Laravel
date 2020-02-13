<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Models\Document\Document;
use Dompdf\Dompdf;

class PDFDocTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'PDFDocTemplateLoader';

    /**
     * @param Document $document
     * @param bool $save
     * @return bool
     * @throws \Exception
     */
    protected function make(Document $document, $save = false)
    {
        $domPdf = new Dompdf([
            'defaultFont' => 'calibri'
        ]);

        $domPdf->loadHtml(
            view($document->getTemplate(), [
                'document' => $document
            ])
        );

        $domPdf->setPaper('A4', 'landscape');

        $domPdf->render();

        if ($save === true) {
            $this->saveDocument($document, $domPdf->output());
        } else {
            $domPdf->stream($document->title);
        }

        return true;
    }
}
