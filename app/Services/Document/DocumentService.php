<?php

namespace DocumentBundle\Service;

use App\Models\Document\Document;
use AppBundle\Interfaces\CheckNormalizeInterface;
use AppBundle\Traits\UserOfContainerTrait;
use AppBundle\Helper\EntityManagerTrait;
use DocumentBundle\Service\CheckNormalize\DocumentServiceCheckNormalizeTrait;
use IntegrationBundle\ParseAction\DocumentCreateAction;
use LinkBundle\Entity\Link;
use QueueBundle\Entity\Task;
use QueueBundle\Entity\TaskProcedure;
use QueueBundle\Service\QueueService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\User;

class DocumentService implements CheckNormalizeInterface
{
    use EntityManagerTrait;
    use UserOfContainerTrait;
    use DocumentServiceCheckNormalizeTrait;

    private $container;

    public function __construct(
        ContainerInterface $container
    )
    {
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->container = $container;
    }

    /**
     * Создать документ
     *
     * @param $typeId
     * @param null $links
     * @param null $user
     * @param bool $save
     * @param null|array $docFields
     * @throws \Exception
     */
    public function createDocument($typeId, $save = false, $docFields = null)
    {
        $document = new Document();
        $document->beforeCreate();

        $document->type_id = $typeId;
        $document->title = $this->parseFileName($document);

        $this->setDocFields($document, $docFields);

        $document->save();

        $this->createTaskToMakeDocument($document);
    }

    private function createTaskToMakeDocument(Document $document)
    {
        $procedure = $this->getEntityManager()->getRepository(TaskProcedure::class)->findOneByMethod(
            DocumentCreateAction::NAME
        );

        $task = new Task();
        $task->beforeCreate();
        $task->setProcedure($procedure);
        $task->document = $document;

        $this->saveEntity($task);
    }

    /**
     * Проставить поля в документе
     *
     * @param Document $document
     * @param $fields
     * @return Document|null
     */
    private function setDocFields(Document $document, $fields)
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
     */
    protected function parseFileName(Document $document)
    {
        $params = [];

        $loader = new \Twig\Loader\ArrayLoader([
            'index.html' => $document->type->title,
        ]);

        $twig = new \Twig\Environment($loader);

        $links = $document->getLinks();

        if ($links !== null) {
            $params = array_merge($params, [
                'links' => $links,
                'link' => $links[0] ?? null
            ]);
        }

        $name = $twig->render('index.html', $params);

        return $name. '.'. $document->getExtensionName();
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
        $documents = $this->getEntityManager()->getRepository(Document::class)->findByUser($user);

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

        $document = $this->getEntityManager()->getRepository(Document::class)->find($id);
        if (null === $document) {
            throw new \LogicException('Документ не найден');
        }

        return $document;
    }
}
