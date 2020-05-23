<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Http\Resource\DocumentShowResource;
use App\Http\Responses\ActionResponse;
use App\Models\Document\Document;
use App\Models\News\ExternalNewsSource;
use App\Service\Document\DocumentService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return ExternalNewsSource::paginate(10, ['*'], 'DocumentsList', $page);
    }

    /**
     * Display the specified resource.
     *
     * @param Document $document
     * @return DocumentShowResource
     */
    public function show(Document $document): DocumentShowResource
    {
        return new DocumentShowResource($document);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Document $document
     * @return ActionResponse
     */
    public function destroy(Document $document): ActionResponse
    {
        $document->deleteFile();

        return new ActionResponse($document->delete() > 0);
    }

    /**
     * Скачать документ / Download Document
     * @param int $documentId
     * @return void|null
     */
    public function download(int $documentId)
    {
        $document = Document::find($documentId);
        if (!$document->fileExists()) {
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
