<?php


use App\Bundles\Document\Models\DocumentExtension;

class DocumentExtensionSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(DocumentExtension::class, 'data_document_extension');
    }
}
