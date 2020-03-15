<?php

namespace App\Services\Document;

use App\Interfaces\ModelWithDocuments;
use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Models\Supply\OneTForm;
use App\Models\Supply\ProductTransportWaybill;
use App\Models\Supply\QualityCertificate;

abstract class AbstractSubDocumentService
{
    const TARGET_CLASS = OneTForm::class;
    const TARGET_TYPE = DocumentType::ONE_T_FORM_ID;

    /**
     * @param int $supplyId
     * @return ModelWithDocuments
     */
    public static function getOrCreate(int $supplyId): ModelWithDocuments
    {
        return self::getBySupply($supplyId) ?? self::createBySupply($supplyId);
    }

    /**
     * @param int $supplyId
     * @return ModelWithDocuments
     */
    public static function createBySupply(int $supplyId): ModelWithDocuments
    {
        $class = static::TARGET_CLASS;
        $form = new $class;
        $form->supply_id = $supplyId;
        $form->save();

        return $form;
    }

    /**
     * @param int $supplyId
     * @return ModelWithDocuments
     */
    public static function getBySupply(int $supplyId): ?ModelWithDocuments
    {
        $class = static::TARGET_CLASS;
        return $class::where('supply_id', $supplyId)->first();
    }

    /**
     * @param ModelWithDocuments $form
     * @return Document
     * @throws \Throwable
     */
    public static function createDocument(ModelWithDocuments $form): Document
    {
        $methods = [
            OneTForm::class => 'addOneTForms',
            ProductTransportWaybill::class => 'addProductTransportWaybills',
            QualityCertificate::class => 'addQualityCertificates',
        ];

        $method = $methods[static::TARGET_CLASS];

        $document = DocumentCreator::getInstance(static::TARGET_TYPE)
            ->$method($form->id)
            ->build(true)
            ->get();

        $form->documents[] = $document;

        return $document;
    }
}
