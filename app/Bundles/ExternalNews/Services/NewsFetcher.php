<?php

namespace App\Bundles\ExternalNews\Services;

use App\Bundles\ExternalNews\Contracts\RssParser;
use App\Bundles\ExternalNews\Models\ExternalNews;
use App\Bundles\ExternalNews\Models\ExternalNewsSource;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class NewsFetcher
{
    protected $rss;

    public function __construct(RssParser $rss)
    {
        $this->rss = $rss;
    }

    /**
     * @return Collection|iterable<string, ExternalNews>
     */
    public function fetch(ExternalNewsSource $source): Collection
    {
        $entries = [];

        foreach ($this->rss->parse($source->link) as $item) {
            $entry = $this->prepareItem($item, $source);
            $entries[$entry->link] = $entry;
        }

        return new Collection($entries);
    }

    /**
     * @param array<string, mixed> $item
     */
    protected function prepareItem(array $item, ExternalNewsSource $source): ?ExternalNews
    {
        if (! Arr::has($item, ['title', 'pubDate', 'link'])) {
            return null;
        }

        $news = new ExternalNews();
        $news->title = $item['title'];
        $news->pub_date = $item['pubDate'];
        $news->link = $item['link'];
        $news->description = $item['description'] ?? null;
        $news->source_id = $source->id;

        return $news;
    }
}
