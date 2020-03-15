<?php

namespace App\Services;

use App\Models\Document\DocumentType;
use App\Models\Supply\QualityCertificate;
use App\Services\Document\AbstractSubDocumentService;

class QualityCertificateService extends AbstractSubDocumentService
{
    public const TARGET_CLASS = QualityCertificate::class;
    public const TARGET_TYPE = DocumentType::QUALITY_CERTIFICATE_ID;
}
