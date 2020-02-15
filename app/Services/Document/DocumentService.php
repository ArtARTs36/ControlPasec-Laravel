<?php

namespace App\Service\Document;

use App\Models\Document\Document;
use App\User;

class DocumentService
{
    /**
     * Обновить название файла
     *
     * @param Document $document
     * @return Document
     * @throws \Throwable
     */
    public static function refreshFileName(Document $document)
    {
        $document->title = self::parseFileName($document);
        $document->save();
        return $document;
    }

//    private static function createTaskToMakeDocument(Document $document)
//    {
//        $procedure = $this->getEntityManager()->getRepository(TaskProcedure::class)->findOneByMethod(
//            DocumentCreateAction::NAME
//        );
//
//        $task = new Task();
//        $task->beforeCreate();
//        $task->setProcedure($procedure);
//        $task->document = $document;
//
//        $this->saveEntity($task);
//    }

    /**
     * Сгенерировать название для файла
     *
     * @param Document $document
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public static function parseFileName(Document $document)
    {
        $tmpFile = time();
        $path = __DIR__ . '/../../../resources/views/'. $tmpFile . '.blade.php';
        file_put_contents(
            $path,
            $document->type->title
        );

        return view($tmpFile, ['doc' => $document])->render() . '.' . $document->getExtensionName();
    }

    public static function getDownloadLink($document)
    {
        $document = self::getDocument($document);

        return implode(DIRECTORY_SEPARATOR, [
            '',
            env('DOCUMENT_DOWNLOAD_DIR'),
            $document->getFolder(),
            $document->uuid,
            $document->getFileName()
        ]);
    }

    /**
     * @param Document[] $documents
     */
    public function setDownloadLinks($documents)
    {
        foreach ($documents as $document) {
            $document->downloadLink = $this->getDownloadLink($document);
        }
    }

    public function getDocsWithDownloadLinksByUser(User $user)
    {
        $documents = Document::where('user', $user->id);

        $this->setDownloadLinks([$documents]);

        return $documents;
    }

    /**
     * Отменить создание документа
     *
     * @param $id
     * @param bool $isCheckGranted
     * @return bool
     */
    public function cancelCreationDocument($id, $isCheckGranted = true)
    {
        $document = $this->getDocument($id);
        if ($document->ready === true) {
            throw new \LogicException('Документ уже создан!');
        }

        if ($isCheckGranted === true && $document->user->getId() !== $this->getUser()->getId()) {
            throw new \LogicException('Вы не можете отменить создание чужого документа!');
        }

        /** @var Task $task */
        $task = $this->getEntityManager()->getRepository(Task::class)->findOneByDocument($document);
        if (null === $task) {
            throw new \LogicException('Не найдена задача на создание документа!');
        }

        QueueService::cancelTask($task);

        return true;
    }

    /**
     * @param $id
     * @return object|null|Document
     */
    public static function getDocument($id)
    {
        if ($id instanceof Document) {
            return $id;
        }

        $document = Document::find($id);
        if (null === $document) {
            throw new \LogicException('Документ не найден');
        }

        return $document;
    }
}
