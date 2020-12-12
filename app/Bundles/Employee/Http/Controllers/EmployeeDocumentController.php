<?php

namespace App\Bundles\Employee\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Document\Http\Resources\DocumentResource;
use App\Bundles\Employee\Models\Employee;
use App\Services\Document\DocumentCreator;

class EmployeeDocumentController extends Controller
{
    /**
     * @tag Employee
     */
    public function byType(Employee $employee, int $typeId): DocumentResource
    {
        $document = DocumentCreator::getInstance($typeId)->save();

        $document->employees()->attach($employee->id);

        $document->build();

        return new DocumentResource($document);
    }
}
