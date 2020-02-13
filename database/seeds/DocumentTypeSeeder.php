<?php

use App\Models\Document\DocumentType;

class DocumentTypeSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $mapManager = new MapFindManager();
        $mapManager->add(
            \App\Models\Document\DocumentLoader::class,
            'loader_name',
            'loader_id',
            'name'
        );

        $this->fillModelWithMap(DocumentType::class, 'data_document_type', $mapManager);
    }
}
