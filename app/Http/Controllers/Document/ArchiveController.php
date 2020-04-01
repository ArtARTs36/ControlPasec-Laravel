<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Services\ArchiveService;

class ArchiveController extends Controller
{
    public function download(int $timestamp, string $name)
    {
        return response()->download(
            ArchiveService::getStoragePath($timestamp, $name)
        )->deleteFileAfterSend();
    }
}
