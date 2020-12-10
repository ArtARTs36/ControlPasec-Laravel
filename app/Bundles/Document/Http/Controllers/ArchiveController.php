<?php

namespace App\Bundles\Document\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Document\Support\ArchivePath;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ArchiveController extends Controller
{
    public function download(int $timestamp, string $name): BinaryFileResponse
    {
        return response()->download(
            ArchivePath::getStoragePath($timestamp, $name)
        )->deleteFileAfterSend();
    }
}
