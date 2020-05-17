<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Services\ArchiveService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ArchiveController extends Controller
{
    /**
     * @param int $timestamp
     * @param string $name
     * @return BinaryFileResponse
     */
    public function download(int $timestamp, string $name): BinaryFileResponse
    {
        return response()->download(
            ArchiveService::getStoragePath($timestamp, $name)
        )->deleteFileAfterSend();
    }
}
