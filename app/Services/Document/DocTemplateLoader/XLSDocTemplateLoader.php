<?php

namespace App\Services\Document\DocTemplateLoader;

use DocumentBundle\Entity\Document;
use DocumentBundle\TwigExtension\DocumentTwigExtension;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class XLSDocTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'XLSDocTemplateLoader';

    const XLS_TEMPLATE_DIR = self::TEMPLATE_DIR . 'XLSTemplates/';
    const XLS_TEMPLATE_DIR_FULL_PATH = self::TEMPLATE_DIR_FULL_PATH . 'XLSTemplates/';

    /**
     * @param Document $document
     * @param bool $save
     * @throws \Exception
     */
    protected function make(Document $document, $save = false)
    {
        $file = self::XLS_TEMPLATE_DIR_FULL_PATH . $document->type->template;

        $reader = new Xls();

        $template = $reader->load($file);

        $this->renderDataTemplate($document, $template);

        $writer = IOFactory::createWriter($template, "Xls");

        $writer->save($this->getSavePath($document));
    }

    /**
     * Отрендерить шаблон данных
     *
     * @param Document $document
     * @return mixed
     * @throws \Exception
     */
    private function renderDataTemplate(Document $document, Spreadsheet $template)
    {
        $dataFile = self::XLS_TEMPLATE_DIR . $this->getDataFileName($document);

        $this->prepareTwig($template);

        return $this->getTwigOfContainer()->render($dataFile, [
            'document' => $document,
            'link' => $document->getLinks()[0],
            'links' => $document->getLinks()
        ]);
    }

    private function prepareTwig(Spreadsheet $template)
    {
        $twig = $this->getTwigOfContainer();

        $extension = new DocumentTwigExtension($template);

        $twig->addExtension($extension);
    }

    /**
     * Получить название файла, которые содержит данные для заполнения шаблона
     *
     * @param Document $document
     * @return mixed
     */
    private function getDataFileName(Document $document)
    {
        return str_replace(
            '.'. $document->type->loader->extension->getName(),
            '.data.twig',
            $document->type->template
        );
    }
}
