<?php

namespace App\Services\Document;

use App\Interfaces\ModelWithDocuments;
use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Models\Supply\OneTForm;

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
        $form->supply = $supplyId;
        $form->save();

        return $form;
    }

    /**
     * @param int $supplyId
     * @return ModelWithDocuments
     */
    public static function getBySupply(int $supplyId): ModelWithDocuments
    {
        $class = static::TARGET_CLASS;
        return $class::where('supply_id', $supplyId)->first();
    }

    /**
     * @param OneTForm $form
     * @return Document
     * @throws \Throwable
     */
    public static function createDocument(OneTForm $form): Document
    {
        $document = DocumentCreator::getInstance(static::TARGET_TYPE)
            ->addProductTransportWaybills($form->id)
            ->build(true)
            ->get();

        $form->documents[] = $document;

        return $document;
    }
}
