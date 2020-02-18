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
        $domPdf = $this->createDomPdf();

        $this->loadDocumentInDom($domPdf, $document);

        $domPdf->render();

        if ($save === true) {
            $this->saveDocument($document, $domPdf->output());
        } else {
            $domPdf->stream($document->title);
        }

        return true;
    }

    /**
     * @param Document[] $documents
     * @param bool $save
     * @return bool
     * @throws \Throwable
     */
    protected function makeMany($documents, $save = false)
    {
        $baseDocument = $documents[0];

        $domPdf = $this->createDomPdf();

        $template = '';
        foreach ($documents as $i => $document) {
            $template .= $this->renderTemplate(
                $document,
                $i == 0,
                (next($documents) ? false : true));
        }

        file_put_contents('kuku.html', $template);

        $domPdf->loadHtml($template);
        $domPdf->render();
        if ($save === true) {
            $this->saveDocument($baseDocument, $domPdf->output());
        } else {
            $domPdf->stream($baseDocument->title);
        }

        return true;
    }

    protected function createDomPdf()
    {
        $domPdf = new Dompdf([
            'defaultFont' => 'calibri'
        ]);

        $domPdf->setPaper('sra4');

        return $domPdf;
    }

    protected function loadDocumentInDom(Dompdf $domPdf, Document $document)
    {
        $domPdf->loadHtml(
            $this->renderTemplate($document, true)
        );
    }

    protected function renderTemplate(Document $document, $isFirstDocument = false, $isEndDocument = true)
    {
        return view($document->getTemplate(), [
            'document' => $document,
            'isFirstDocument' => $isFirstDocument,
            'isEndDocument' => $isEndDocument
        ])->render();
    }
}
