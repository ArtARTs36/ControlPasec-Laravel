<?php

namespace App\Bundles\ExternalNews\Contracts;

interface RssParser
{
    public function parse(string $url): array;
}
