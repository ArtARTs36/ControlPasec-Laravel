<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Models\Document\Document;
use PhpOffice\PhpWord\TemplateProcessor;

class PhpWordDocTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'PhpWordDocTemplateLoader';

    /**
     * @param Document $document
     * @param bool $save
     * @return bool|string
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \Throwable
     */
    protected function make(Document $document, $save = false)
    {
        $fileData = $document->getTemplate() . '_data';

        $processor = new TemplateProcessor($document->getTemplateFullPath(true));
        $this->prepareData($processor, view($fileData, [
            'document' => $document,
            'templateProcessor' => $processor,
        ])->render());

        $savePath = $this->getSavePath($document);

        $processor->saveAs($savePath);

        return file_exists($savePath) ? $savePath : false;
    }

    protected function makeMany($documents, $save = false)
    {
        // TODO: Implement makeMany() method.
    }

    /**
     * @param TemplateProcessor $processor
     * @param string $data
     */
    private function prepareData(TemplateProcessor $processor, string $data)
    {
        $data = json_decode($data, true);
        if (!empty($data['variables']) && ($variables = $data['variables']) && is_array($variables)) {
            foreach ($variables as $key => $value) {
                $processor->setValue($key, $value);
            }
        }

        if (!empty($data['tables']) && ($tables = $data['tables']) && is_array($tables)) {
            foreach ($tables as $triggerMapKey => $values) {
                if (!is_array($values)) {
                    continue;
                }

                if (is_numeric($triggerMapKey)) {
                    $triggerMapKey = array_key_first($values[0]);
                }

                $processor->cloneRowAndSetValues($triggerMapKey, $values);
            }
        }
    }
}
