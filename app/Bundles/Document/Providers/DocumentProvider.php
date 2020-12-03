<?php

namespace App\Bundles\Document\Providers;

use App\Based\Contracts\BundleProvider;

final class DocumentProvider extends BundleProvider
{
    public function register()
    {
        $this->app->register(EventProvider::class);
    }
}
