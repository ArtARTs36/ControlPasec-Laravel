<?php

namespace App\Bundles\Vocab\Services;

use App\Bundles\Vocab\Repositories\VocabWordRepository;
use App\Bundles\Vocab\Models\VocabWord;
use Illuminate\Support\Collection;
use App\Bundles\Vocab\Contracts\NameInclinator;

class WordService
{
    private $inclinator;

    private $repository;

    public function __construct(NameInclinator $inclinator, VocabWordRepository $repository)
    {
        $this->inclinator = $inclinator;
        $this->repository = $repository;
    }

    public function getOrCreateByNominatives(array $words): Collection
    {
        $declensions = $this->getByNominatives(...$words);

        foreach ($words as $word) {
            if ($declensions->offsetExists($word)) {
                continue;
            }

            $declensions->put($word, $this->inclinator->decline($word));
        }

        return $declensions;
    }

    public function getByNominatives(string ...$words): Collection
    {
        return $this->repository
            ->getByNominatives($words)
            ->pluck(null, VocabWord::FIELD_NOMINATIVE);
    }
}
