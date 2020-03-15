<?php

namespace App\Services;

use App\Models\Document\DocumentType;
use App\Models\Supply\OneTForm;
use App\Services\Document\AbstractSubDocumentService;

class OneTFormService extends AbstractSubDocumentService
{
    const TARGET_CLASS = OneTForm::class;
    const TARGET_TYPE = DocumentType::ONE_T_FORM_ID;
}
