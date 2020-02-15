<?php

namespace App\Services\Go;

use App\Models\Document\Document;
use App\Service\Document\DocumentService;

class XlsxRenderGoProgram extends GoProgram
{
    const NAME = 'xlsx_render';

    /** @var string */
    private $savePath;

    /** @var false|string */
    private $templatePath;

    /** @var string */
    private $data;

    /** @var string */
    private $dataFilePath;

    public function __construct($documentPath, $template, $data)
    {
        $this->savePath = public_path($documentPath);
        $this->templatePath = realpath($template);
        $this->data = $data;

        $this->createFolder();
    }

    protected function process()
    {
        $this->data = json_encode($this->data);
        $this->dataFilePath = $this->getExecutor()->getPathToData() . time() . '.json';

        file_put_contents($this->dataFilePath, $this->data);
        $this->dataFilePath = realpath($this->dataFilePath);

        $this->getExecutor()
            ->addParameter($this->templatePath)
            ->addParameter($this->savePath)
            ->addParameter($this->dataFilePath);
    }

    public static function createByDocument(Document $document, $data): self
    {
        return new self(
            DocumentService::getDownloadLink($document),
            $document->getTemplateFullPath(true),
            $data
        );
    }

    protected function createFolder()
    {
        $parse = explode('/', $this->savePath);
        array_pop($parse);

        $folder = implode('/', $parse);
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    }

    protected function response()
    {
        return file_exists($this->savePath) ? $this->savePath : false;
    }
}
