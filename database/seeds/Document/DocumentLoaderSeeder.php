<?php

use App\Bundles\Document\Models\DocumentExtension;
use App\Bundles\Document\Models\DocumentLoader;

class DocumentLoaderSeeder extends CommonSeeder
{
    public function run()
    {
        $mapManager = new MapFindManager();
        $mapManager->add(
            DocumentExtension::class,
            'extension_name',
            'extension_id',
            DocumentExtension::FIELD_NAME
        );

        $this->fillModelWithMap(DocumentLoader::class, 'data_document_loader', $mapManager);
    }
}
