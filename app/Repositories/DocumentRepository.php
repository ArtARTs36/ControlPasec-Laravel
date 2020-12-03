<?php

namespace App\Repositories;

use App\Based\Interfaces\ModelWithDocuments;
use App\Models\Document\Document;
use App\Models\Supply\OneTForm;
use App\Models\Supply\ProductTransportWaybill;
use App\Models\Supply\QualityCertificate;
use App\Models\Supply\ScoreForPayment;
use App\Services\Document\DocumentCreator;

class DocumentRepository
{
    private $modelClass;

    private $targetType;

    public function __construct(string $modelClass, int $targetType)
    {
        $this->modelClass = $modelClass;
        $this->targetType = $targetType;
    }

    /**
     * @param int $supplyId
     * @return ModelWithDocuments
     */
    public function getOrCreate(int $supplyId): ModelWithDocuments
    {
        return $this->getBySupply($supplyId) ?? $this->createBySupply($supplyId);
    }

    /**
     * @param int $supplyId
     * @return ModelWithDocuments
     */
    public function createBySupply(int $supplyId): ModelWithDocuments
    {
        /** @var ModelWithDocuments $form */
        $form = new $this->modelClass;
        $form->supply_id = $supplyId;
        $form->save();

        return $form;
    }

    /**
     * @param int $supplyId
     * @return ModelWithDocuments
     */
    public function getBySupply(int $supplyId): ?ModelWithDocuments
    {
        return $this->modelClass::where('supply_id', $supplyId)->first();
    }

    /**
     * @param ModelWithDocuments $form
     * @return Document
     * @throws \Throwable
     */
    public function createDocument(ModelWithDocuments $form): Document
    {
        $methods = [
            OneTForm::class => 'addOneTForms',
            ProductTransportWaybill::class => 'addProductTransportWaybills',
            QualityCertificate::class => 'addQualityCertificates',
            ScoreForPayment::class => 'addScores',
        ];

        $method = $methods[$this->modelClass];

        $document = DocumentCreator::getInstance($this->targetType)
            ->$method($form->id)
            ->build(true)
            ->get();

        $form->documents[] = $document;

        return $document;
    }
}
