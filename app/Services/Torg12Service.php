<?php

namespace App\Services;

use App\Models\Document\DocumentType;
use App\Models\Supply\ProductTransportWaybill;
use App\Services\Document\AbstractSubDocumentService;

class Torg12Service extends AbstractSubDocumentService
{
    public const TARGET_CLASS = ProductTransportWaybill::class;
    public const TARGET_TYPE = DocumentType::TORG_12_ID;
}
