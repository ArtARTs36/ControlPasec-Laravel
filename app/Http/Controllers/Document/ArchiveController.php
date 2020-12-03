<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Services\ArchiveService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ArchiveController extends Controller
{
    public function download(int $timestamp, string $name): BinaryFileResponse
    {
        return response()->download(
            ArchiveService::getStoragePath($timestamp, $name)
        )->deleteFileAfterSend();
    }
}
