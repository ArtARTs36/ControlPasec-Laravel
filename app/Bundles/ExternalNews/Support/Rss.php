<?php

namespace App\Bundles\ExternalNews\Support;

use App\Bundles\ExternalNews\Contracts\RssParser;

class Rss implements RssParser
{
    public function parse(string $url): array
    {
        $xml = simplexml_load_file($url);

        $items = [];

        foreach ($xml->children() as $child) {
            foreach ($child->children() as $field => $value) {
                if ($field == 'item') {
                    $items[] = (array) $value;
                }
            }
        }

        return $items;
    }
}
