<?php

use App\Bundles\Document\Models\DocumentType;

class DocumentTypeSeeder extends CommonSeeder
{
    public function run()
    {
        $mapManager = new MapFindManager();
        $mapManager->add(
            \App\Bundles\Document\Models\DocumentLoader::class,
            'loader_name',
            'loader_id',
            'name'
        );

        $this->fillModelWithMap(DocumentType::class, 'data_document_type', $mapManager);
    }
}
