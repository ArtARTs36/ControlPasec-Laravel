<?php

namespace App\Services\Go;

use App\Based\GoBridge\GoProgram;
use App\Models\Document\Document;
use App\Services\Document\DocumentService;

class XlsxRender extends GoProgram
{
    public const NAME = 'xlsx_render';
    protected const IS_BINARY = true;

    public static function renderByDocument(Document $document, $data): string
    {
        return (new static())->render(
            DocumentService::getDownloadLink($document),
            $document->getTemplateFullPath(),
            $data
        );
    }

    public function render(string $savePath, string $template, array $data): string
    {
        $savePath = public_path($savePath);

        $this->createFolder($savePath);

        $data = json_encode($data);
        $dataFilePath = $this->getExecutor()->getPathToData() . time() . '.json';

        file_put_contents($dataFilePath, $data);
        $dataFilePath = realpath($dataFilePath);

        $this
            ->getExecutor()
            ->getCommand()
            ->addParameter(realpath($template))
            ->addParameter($savePath)
            ->addParameter($dataFilePath)
            ->execute();

        return $savePath;
    }

    protected function createFolder(string $savePath)
    {
        $parse = explode('/', $savePath);
        array_pop($parse);

        $folder = implode('/', $parse);
        if (! file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    }
}
