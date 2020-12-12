<?php

namespace App\Bundles\Document\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Document\Http\Resources\DocumentShowResource;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Document\Models\Document;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DocumentController extends Controller
{
    /**
     * @tag Docs
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return Document::query()
            ->paginate(10, ['*'], 'DocumentsList', $page);
    }

    /**
     * @tag Docs
     */
    public function show(Document $document): DocumentShowResource
    {
        return new DocumentShowResource($document);
    }

    /**
     * @tag Docs
     */
    public function destroy(Document $document): ActionResponse
    {
        $document->deleteFile();

        return new ActionResponse($document->delete() > 0);
    }

    /**
     * Скачать документ / Download Document
     * @tag Docs
     * @param int $documentId
     * @return void|null
     */
    public function download(int $documentId)
    {
        $document = Document::find($documentId);
        if (! $document->fileExists()) {
            return null;
        }

        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($document->title));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($document->getFullPath()));

        readfile($document->getFullPath());
        exit;
    }
}
