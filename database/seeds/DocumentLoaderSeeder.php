<?php

use App\Models\Document\DocumentExtension;
use App\Models\Document\DocumentLoader;

class DocumentLoaderSeeder extends CommonSeeder
{
    public function run()
    {
        $mapManager = new MapFindManager();
        $mapManager->add(
            DocumentExtension::class,
            'extension_name',
            'extension_id',
            'name'
        );

        $this->fillModelWithMap(DocumentLoader::class, 'data_document_loader', $mapManager);
    }
}
