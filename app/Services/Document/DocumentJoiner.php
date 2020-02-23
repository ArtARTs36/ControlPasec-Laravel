<?php

namespace App\Services\Document;

use App\Models\Document\Document;
use App\Service\Document\DocumentService;
use App\Services\Go\GoProgramExecutor;
use App\Services\Shell\ShellCommand;

class DocumentJoiner
{
    /**
     * @param Document[] $documents
     * @param null $savePath
     * @return bool
     */
    public static function join(array $documents, $savePath = null)
    {
        $ext = $documents[0]->getExtensionName();
        foreach ($documents as $document) {
            if ($ext !== $document->getExtensionName()) {
                return false;
            }
        }

        if (!method_exists(self::class, $ext)) {
            return false;
        }

        return self::$ext($documents, $savePath);
    }

    /**
     * @param Document[] $documents
     * @param string $savePath
     * @return string|false
     */
    public static function pdf(array $documents, string $savePath = null)
    {
        $executorPath = GoProgramExecutor::GO_ROOT_DIR . '/pdfcpu';

        $savePath = $savePath ?? DocumentService::getDownloadLink($documents[0], true) . '.merged.pdf';

        $command = ShellCommand::getInstance($executorPath)
            ->addParameter('merge')
            ->addParameter($savePath);

        foreach ($documents as $document) {
            DocumentService::buildIfNotExists($document);

            $command->addParameter(
                DocumentService::getDownloadLink($document, true)
            );
        }

        $command->execute();

        return file_exists($savePath) ? $savePath : false;
    }
}
