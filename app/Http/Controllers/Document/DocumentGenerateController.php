<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\GenerateManyTypesRequest;
use App\Http\Resource\ArchiveResource;
use App\Http\Resource\DocumentResource;
use App\Interfaces\ModelWithDocuments;
use App\Models\Document\DocumentType;
use App\Models\Supply\OneTForm;
use App\Models\Supply\ProductTransportWaybill;
use App\Models\Supply\QualityCertificate;
use App\Models\Supply\Supply;
use App\Repositories\DocumentRepository;
use App\ScoreForPayment;
use App\Services\Document\DocumentBuilder;
use App\Support\Archiver\Zipper;

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
        $form = $this->build($supply, $typeId);

        return new DocumentResource($form->getDocument());
    }

    public function generateManyTypes(Supply $supply, GenerateManyTypesRequest $request): ArchiveResource
    {
        $files = [];

        foreach ($request->types as $type) {
            $form = $this->build($supply, $type);

            $files[] = $form->getDocument()->getFullPath();
        }

        $archive = (new Zipper())->compress($files, 'archive.zip');

        return new ArchiveResource($archive);
    }

    private function build(Supply $supply, int $typeId): ModelWithDocuments
    {
        $repo = $this->getDocRepo($typeId);

        $form = $repo->getOrCreate($supply->id);
        if ($form->isNotExistsDocument()) {
            $repo->createDocument($form);
        }

        DocumentBuilder::build($form->getDocument(), true);

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
