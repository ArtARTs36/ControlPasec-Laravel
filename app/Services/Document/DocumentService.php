<?php

namespace App\Service\Document;

use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\User;

class DocumentService
{
    /**
     * Создать документ
     *
     * @param $typeId
     * @param bool $save
     * @param null|array $docFields
     * @return Document
     * @throws \Throwable
     */
    public static function createDocument($typeId, $save = false, $docFields = null)
    {
        $document = new Document();
        $document->beforeCreate();

        $document->type = DocumentType::find($typeId);
        $document->type_id = $typeId;
        $document->title = self::parseFileName($document);

        self::setDocFields($document, $docFields);

        unset($document->type);
        $document->save();

        return $document;

//        self::createTaskToMakeDocument($document);
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
     * Проставить поля в документе
     *
     * @param Document $document
     * @param $fields
     * @return Document|null
     */
    private static function setDocFields(Document $document, $fields)
    {
        if ($fields === null) {
            return $document;
        }

        foreach ($fields as $field => $value) {
            $document->$field = $value;
        }

        return $document;
    }

    /**
     * Добавить ссылки к документу
     *
     * @param Document $document
     * @param array|integer $links
     */
    private function addLinksForDocument(Document $document, $links)
    {
        if (!is_array($links)) {
            $links = [$links];
        }

        foreach ($links as $link) {
            if ($link instanceof Link) {
                $document->addLink($link);
            } else {
                $document->addLink($this->getEntityManager()->getReference(Link::class, $link));
            }
        }
    }

    /**
     * Сгенерировать название для файла
     *
     * @param Document $document
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    protected static function parseFileName(Document $document)
    {
        $tmpFile = time();
        $path = __DIR__ . '/../../../resources/views/'. $tmpFile . '.blade.php';
        file_put_contents(
            $path,
            $document->type->title
        );

        return view($tmpFile, $document)->render() . '.' . $document->getExtensionName();
    }

    public function getDownloadLink(Document $document)
    {
        $dir = $this->container->getParameter('document_dir');

        return implode(DIRECTORY_SEPARATOR, [
            '',
            $dir,
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

        $this->setDownloadLinks($documents);

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
    public function getDocument($id)
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
