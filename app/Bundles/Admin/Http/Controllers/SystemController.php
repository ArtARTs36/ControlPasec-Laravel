<?php

namespace App\Bundles\Admin\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Admin\Http\Resources\SavedSnapshotResource;
use App\Bundles\Admin\Http\Resources\SnapshotResource;
use ArtARTs36\SystemInfo\Contracts\System;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class SystemController extends Controller
{
    protected $system;

    public function __construct(System $system)
    {
        $this->system = $system;
    }

    public function index(): AnonymousResourceCollection
    {
        return SavedSnapshotResource::collection();
    }

    public function snapshot(): SnapshotResource
    {
        return new SnapshotResource($this->system->createSnapshot());
    }
}
