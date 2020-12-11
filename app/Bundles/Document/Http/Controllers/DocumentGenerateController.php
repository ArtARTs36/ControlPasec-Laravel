<?php

namespace App\Bundles\Document\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Document\Http\Requests\GenerateManyTypesRequest;
use App\Bundles\Document\Http\Resources\ShowArchive;
use App\Bundles\Document\Http\Resources\DocumentResource;
use App\Based\Interfaces\ModelWithDocuments;
use App\Models\Document\DocumentType;
use App\Bundles\Supply\Models\OneTForm;
use App\Bundles\Supply\Models\ProductTransportWaybill;
use App\Bundles\Supply\Models\QualityCertificate;
use App\Bundles\Supply\Models\Supply;
use App\Bundles\Document\Repositories\DocumentRepository;
use App\Bundles\Supply\Models\ScoreForPayment;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentCreator;
use App\Based\Support\Archiver\Zipper;

class DocumentGenerateController extends Controller
{
    private const TYPES_MODELS = [
        DocumentType::TORG_12_ID => ProductTransportWaybill::class,
        DocumentType::QUALITY_CERTIFICATE_ID => QualityCertificate::class,
        DocumentType::ONE_T_FORM_ID => OneTForm::class,
        DocumentType::SCORE_FOR_PAYMENT_ID => ScoreForPayment::class,
    ];

    public function create(int $type)
    {
        $document = DocumentCreator::getInstance($type)->save();

        $document->build();

        return new DocumentResource($document);
    }

    public function generate(Supply $supply, int $typeId): DocumentResource
    {
        $form = $this->build($supply, $typeId);

        return new DocumentResource($form->getDocument());
    }

    public function generateManyTypes(Supply $supply, GenerateManyTypesRequest $request): ShowArchive
    {
        $files = [];

        foreach ($request->types as $type) {
            $form = $this->build($supply, $type);

            $files[] = $form->getDocument()->getFullPath();
        }

        $archive = (new Zipper())->compress($files, 'archive.zip');

        return new ShowArchive($archive);
    }

    private function build(Supply $supply, int $typeId): ModelWithDocuments
    {
        $repo = $this->getDocRepo($typeId);

        $form = $repo->getOrCreate($supply->id);
        if ($form->isNotExistsDocument()) {
            $repo->createDocument($form);
        }

        DocumentService::buildWithSpeedAnalyse($form->getDocument(), true);

        return $form;
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
