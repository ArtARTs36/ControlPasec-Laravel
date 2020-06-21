<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Resource\DocumentResource;
use App\Models\Employee\Employee;
use App\Services\Document\DocumentCreator;

class EmployeeDocumentController extends Controller
{
    public function byType(Employee $employee, int $typeId): DocumentResource
    {
        $document = DocumentCreator::getInstance($typeId)->save();

        $document->employees()->attach($employee->id);

        $document->build();

        return new DocumentResource($document);
    }
}
