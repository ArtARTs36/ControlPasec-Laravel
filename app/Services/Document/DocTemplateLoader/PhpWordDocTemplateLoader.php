<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Models\Document\Document;
use PhpOffice\PhpWord\TemplateProcessor;

class PhpWordDocTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'PhpWordDocTemplateLoader';

    /**
     * @param Document $document
     * @return string
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     */
    protected function make(Document $document): string
    {
        $processor = new TemplateProcessor($document->getTemplateFullPath());
        $this->prepareData($processor, $this->includeData($document, $processor));

        $savePath = $this->getSavePath($document);

        $processor->saveAs($savePath);

        return file_exists($savePath) ? $savePath : false;
    }

    protected function includeData(Document $document, TemplateProcessor $processor = null): array
    {
        $path = __DIR__ . '/../../../../resources/views/' .
            $document->getTemplate() . '_data.php';

        return include $path;
    }

    /**
     * @param $documents
     * @return string
     */
    protected function makeMany($documents): string
    {
        // TODO: Implement makeMany() method.
    }

    /**
     * @param TemplateProcessor $processor
     * @param array $data
     */
    private function prepareData(TemplateProcessor $processor, array $data)
    {
        if (!empty($data['variables']) && ($variables = $data['variables']) && is_array($variables)) {
            foreach ($variables as $key => $value) {
                $processor->setValue($key, $value);
            }
        }

        if (!empty($data['tables']) && ($tables = $data['tables']) && is_array($tables)) {
            foreach ($tables as $triggerMapKey => $values) {
                if (! is_array($values) || empty($values)) {
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
