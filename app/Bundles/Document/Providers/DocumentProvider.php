<?php

namespace App\Bundles\Document\Providers;

use App\Based\Contracts\BundleProvider;
use App\Bundles\Document\Contracts\PDFUtility;
use App\Bundles\Document\Support\PdfCpu;

final class DocumentProvider extends BundleProvider
{
    public function register()
    {
        $this->app->register(EventProvider::class);
        $this->app->register(RouteProvider::class);

        $this->app->bind(PDFUtility::class, PdfCpu::class);
    }
}
