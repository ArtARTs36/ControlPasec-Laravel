<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Models\Document\Document;
use DocumentBundle\Exception\DocumentFailedToSaveException;
use DocumentBundle\Helper\TextMinificator;

abstract class AbstractDocTemplateLoader
{
    const NAME = '';

    const TEMPLATE_DIR = '@Document/DocumentTemplates/';

    const TEMPLATE_DIR_FULL_PATH = __DIR__ . '/../../Resources/views/DocumentTemplates/';

    abstract protected function make(Document $document, $save = false);

    public function load(Document $document, $save = false)
    {
        return $this->make($document, $save);
    }

    /**
     * @return Environment
     */
    protected function getTwigOfContainer()
    {
        return $this->container->get('twig');
    }

    /**
     * Получил файл шаблона
     *
     * @param Document $document
     * @return false|string
     */
    protected function getTemplateFileByDocument(Document $document)
    {
        $path = self::TEMPLATE_DIR_FULL_PATH. $document->type->template;

        return file_get_contents($path);
    }

    /**
     * Создать загрузчик Твига
     *
     * @param Document $document
     * @param &$fakeName
     * @return Environment
     */
    protected function createTwigLoader(Document $document, &$fakeName)
    {
        $fakeName = time() . '.html';

        $file = $this->getTemplateFileByDocument($document);
        TextMinificator::minify($file);

        $loader = new \Twig\Loader\ArrayLoader([
            $fakeName => $file,
        ]);

        $twig = new \Twig\Environment($loader);

        foreach ($this->getTwigOfContainer()->getExtensions() as $extension) {
            if (!$twig->hasExtension(get_class($extension))) {
                $twig->addExtension($extension);
            }
        }

        return $twig;
    }

    /**
     * @param Document $document
     * @param null $appendParams
     * @param bool $isMinify
     * @return string
     * @throws \Exception
     */
    protected function getTemplate(
        Document $document,
        $appendParams = null,
        $isMinify = false
    )
    {
        $links = $document->getLinks();

        $params = [
            'document' => $document,
            'links' => $links,
            'link' => $links[0] ?? null
        ];

        if (is_array($appendParams)) {
            $params = array_merge($params, $appendParams);
        }

        return ($isMinify === true) ?
            $this->createTwigLoader($document, $fakeName)->render($fakeName, $params) :
            $this->getTwigOfContainer()->render(self::TEMPLATE_DIR . $document->type->template, $params);
    }

    /**
     * Получить путь для сохранения документа
     *
     * @param Document $document
     * @return string
     * @throws \Exception
     */
    public function getSavePath(Document $document)
    {
        $dir = implode(DIRECTORY_SEPARATOR, [
            base_path(env('DOCUMENT_SAVE_DIR')),
            file_get_contents(base_path(env('DOCUMENT_SAVE_MAP'))),
            $document->uuid
        ]);

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir . DIRECTORY_SEPARATOR . $document->getFileName();
    }

    /**
     * Сохранить документ
     *
     * @param Document $document
     * @param $output
     * @param string $path
     * @return string
     * @throws \Exception
     */
    protected function saveDocument(Document $document, $output, $path = null)
    {
        if ($path === null) {
            $path = $this->getSavePath($document);
        }

        if (file_put_contents($path, $output) === false) {
            throw new DocumentFailedToSaveException($document);
        }

        return $path;
    }
}
