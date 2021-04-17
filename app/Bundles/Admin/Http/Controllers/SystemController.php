<?php

namespace App\Bundles\Admin\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Admin\Http\Resources\SnapshotResource;
use ArtARTs36\SystemInfo\Contracts\System;

class SystemController extends Controller
{
    protected $system;

    public function __construct(System $system)
    {
        $this->system = $system;
    }

    public function snapshot(): SnapshotResource
    {
        return new SnapshotResource($this->system->createSnapshot());
    }
}
