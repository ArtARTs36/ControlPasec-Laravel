<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Bundles\Document\Models\Document;
use Dompdf\Dompdf;

class PDFDocTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'PDFDocTemplateLoader';

    /**
     * @param Document $document
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    protected function make(Document $document): string
    {
        $domPdf = $this->createDomPdf();

        $this->loadDocumentInDom($domPdf, $document);

        $domPdf->render();

        $this->saveDocument($document, $domPdf->output());

        return $this->getSavePath($document);
    }

    /**
     * @param Document[] $documents
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    protected function makeMany($documents): string
    {
        $baseDocument = $documents[0];

        $domPdf = $this->createDomPdf();

        $template = '';
        foreach ($documents as $i => $document) {
            $template .= $this->renderTemplate(
                $document,
                $i == 0,
                (next($documents) ? false : true)
            );
        }

        $domPdf->loadHtml($template);
        $domPdf->render();

        $this->saveDocument($baseDocument, $domPdf->output());

        return $this->getSavePath($baseDocument);
    }

    /**
     * @return Dompdf
     */
    protected function createDomPdf(): Dompdf
    {
        $domPdf = new Dompdf([
            'defaultFont' => 'calibri'
        ]);

        $domPdf->setPaper('sra4');

        return $domPdf;
    }

    /**
     * @param Dompdf $domPdf
     * @param Document $document
     * @throws \Throwable
     */
    protected function loadDocumentInDom(Dompdf $domPdf, Document $document): void
    {
        $domPdf->loadHtml(
            $this->renderTemplate($document, true)
        );
    }

    /**
     * @param Document $document
     * @param bool $isFirstDocument
     * @param bool $isEndDocument
     * @return array|string
     * @throws \Throwable
     */
    protected function renderTemplate(Document $document, $isFirstDocument = false, $isEndDocument = true)
    {
        return view($document->getTemplate(), [
            'document' => $document,
            'isFirstDocument' => $isFirstDocument,
            'isEndDocument' => $isEndDocument
        ])->render();
    }
}
