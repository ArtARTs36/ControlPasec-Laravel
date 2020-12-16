<?php

namespace App\Bundles\ExternalNews\Services;

use App\Bundles\ExternalNews\Contracts\RssParser;
use App\Bundles\ExternalNews\Models\ExternalNews;
use App\Bundles\ExternalNews\Models\ExternalNewsSource;
use App\Bundles\ExternalNews\Repositories\ExternalNewsRepository;

class ExternalNewsCreator
{
    private static $existsNews = null;

    private $parser;

    private $repository;

    public function __construct(RssParser $parser, ExternalNewsRepository $repository)
    {
        $this->parser = $parser;
        $this->repository = $repository;
    }

    public function createBySource(ExternalNewsSource $source): array
    {
        return $this->create([$source]);
    }

    public function create(array $sources = null): array
    {
        $sources = $sources ?? ExternalNewsSource::all();

        $news = [];
        foreach ($sources as $source) {
            $items = $this->parser->parse($source->link);
            $news = array_merge($news, $this->createNews($items, $source));
        }

        return $news;
    }

    private function createNews(array $items, ExternalNewsSource $source): array
    {
        $links = [];
        foreach ($items as $item) {
            if (!isset($item['link'])) {
                continue;
            }

            $links[] = $item['link'];
        }

        static::$existsNews = $this->repository->getByLinks($links)
            ->pluck(ExternalNews::FIELD_ID, ExternalNews::FIELD_LINK);

        $news = [];
        foreach ($items as $item) {
            $news[] = $this->prepareNews($item, $source);
        }

        return $news;
    }

    private function prepareNews(array $item, ExternalNewsSource $source): ?ExternalNews
    {
        if (!isset($item['title']) ||
            !isset($item['pubDate']) ||
            !isset($item['link']) ||
            $this->isExistsNews($item['link'])) {
            return null;
        }

        $news = new ExternalNews();
        $news->title = $item['title'];
        $news->pub_date = $item['pubDate'];
        $news->link = $item['link'];
        $news->description = $item['description'] ?? null;
        $news->source_id = $source->id;
        $news->save();

        return $news;
    }

    private function isExistsNews(string $link): bool
    {
        return isset(self::$existsNews[$link]);
    }
}
