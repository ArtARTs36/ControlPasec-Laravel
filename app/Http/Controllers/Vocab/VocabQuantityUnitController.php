<?php

namespace App\Http\Controllers\Vocab;

use App\Http\Controllers\Controller;
use App\Models\Vocab\VocabQuantityUnit;

class VocabQuantityUnitController extends Controller
{
    public function index()
    {
        return VocabQuantityUnit::all();
    }
}
