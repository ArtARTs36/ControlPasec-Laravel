<?php

namespace App\Http\Controllers\TextDataParser;

use App\Http\Controllers\Controller;
use App\Models\TextDataParser\TextDataParserComponent;

class TextDataParserComponentController extends Controller
{
    public function index()
    {
        return TextDataParserComponent::paginate(10);
    }
}
