<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Http\Resource\DocumentResource;
use App\Models\Document\DocumentType;
use App\Models\Supply\OneTForm;
use App\Models\Supply\ProductTransportWaybill;
use App\Models\Supply\QualityCertificate;
use App\Models\Supply\Supply;
use App\Repositories\DocumentRepository;
use App\ScoreForPayment;
use App\Services\Document\DocumentBuilder;

class DocumentGenerateController extends Controller
{
    private const TYPES_MODELS = [
        DocumentType::TORG_12_ID => ProductTransportWaybill::class,
        DocumentType::QUALITY_CERTIFICATE_ID => QualityCertificate::class,
        DocumentType::ONE_T_FORM_ID => OneTForm::class,
        DocumentType::SCORE_FOR_PAYMENT_ID => ScoreForPayment::class,
    ];

    public function generate(Supply $supply, int $typeId): DocumentResource
    {
        $repo = $this->getDocRepo($typeId);

        $form = $repo->getOrCreate($supply->id);
        if ($form->isNotExistsDocument()) {
            $repo->createDocument($form);
        }

        DocumentBuilder::build($form->getDocument(), true);

        return new DocumentResource($form->getDocument());
    }

    /**
     * @param int $typeId
     * @return DocumentRepository
     */
    private function getDocRepo(int $typeId): DocumentRepository
    {
        $class = static::TYPES_MODELS[$typeId];

        return $class::getDocRepo();
    }
}
