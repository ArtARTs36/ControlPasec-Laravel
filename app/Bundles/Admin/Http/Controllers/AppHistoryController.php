<?php

namespace App\Bundles\Admin\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Admin\Contracts\AppChangeHistory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AppHistoryController extends Controller
{
    protected $changes;

    public function __construct(AppChangeHistory $changes)
    {
        $this->changes = $changes;
    }

    public function index(): ResourceCollection
    {
        return JsonResource::collection($this->changes->all());
    }
}
