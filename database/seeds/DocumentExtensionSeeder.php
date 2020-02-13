<?php


use App\Models\Document\DocumentExtension;

class DocumentExtensionSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $this->fillModel(DocumentExtension::class, 'data_document_extension');
    }
}
