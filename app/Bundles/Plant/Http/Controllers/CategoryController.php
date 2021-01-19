<?php

namespace App\Bundles\Plant\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Plant\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    public function index(): JsonResource
    {
        return JsonResource::collection(Category::all());
    }
}
