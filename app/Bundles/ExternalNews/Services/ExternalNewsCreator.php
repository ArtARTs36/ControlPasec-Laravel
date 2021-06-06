<?php

namespace App\Bundles\ExternalNews\Services;

use App\Bundles\ExternalNews\Contracts\ExternalNewsRepository;
use App\Bundles\ExternalNews\Models\ExternalNews;
use App\Bundles\ExternalNews\Models\ExternalNewsSource;
use Illuminate\Support\Collection;

class ExternalNewsCreator
{
    private $fetcher;

    private $news;

    public function __construct(NewsFetcher $fetcher, ExternalNewsRepository $news)
    {
        $this->fetcher = $fetcher;
        $this->news = $news;
    }

    public function createFromAllSources(): int
    {
        return $this->create(ExternalNewsSource::all()->all());
    }

    public function create(array $sources): int
    {
        /** @var Collection|iterable<string, ExternalNews> $entries */
        $entries = new Collection([]);

        foreach ($sources as $source) {
            $entries = $entries->merge($this->fetcher->fetch($source));
        }

        return $this->news->insertOrIgnore($entries->toArray());
    }
}
