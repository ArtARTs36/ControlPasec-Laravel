<?php

namespace App\Bundles\Admin\Providers;

use App\Based\Contracts\BundleProvider;
use App\Bundles\Admin\Console\Commands\CreateSystemSnapshotCommand;
use App\Bundles\Admin\Contracts\AppChangeHistory;
use App\Bundles\Admin\Models\AdminService;
use App\Bundles\Admin\Services\GitAppChangeHistory;
use App\Bundles\Admin\Support\Accessor;
use ArtARTs36\GitHandler\GitSimpleFactory;
use ArtARTs36\SystemInfo\Contracts\System;
use ArtARTs36\SystemInfo\SystemFacade;
use Illuminate\Http\Request;
use Studio\Totem\Totem;

final class AdminProvider extends BundleProvider
{
    protected $factoriesPath = __DIR__ . '/../Database/Factories';

    public function register()
    {
        $this->app->register(RouteProvider::class);

        $this->registerFactories();

        $this->app->singleton(Accessor::class);

        Totem::auth(function (Request $request) {
            return $this->app->get(Accessor::class)->allowed(AdminService::NAME_TOTEM, $request->getClientIp());
        });

        $this->app->bind(GitAppChangeHistory::class, function () {
            return new GitAppChangeHistory(
                GitSimpleFactory::factory(config('git.back.dir')),
                GitSimpleFactory::factory(config('git.front.dir'))
            );
        });

        $this->app->singleton(AppChangeHistory::class, GitAppChangeHistory::class);

        $this->app->bind(System::class, function () {
            return SystemFacade::get();
        });

        $this->commands(CreateSystemSnapshotCommand::class);
    }
}
