<?php


use App\Models\Document\DocumentExtension;

class DocumentExtensionSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(DocumentExtension::class, 'data_document_extension');
    }
}
