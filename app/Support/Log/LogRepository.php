<?php

namespace App\Support\Log;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class LogRepository implements LogRepositoryInterface
{
    private $reader;

    /**
     * LogRepository constructor.
     * @param LogReaderInterface $reader
     */
    public function __construct(LogReaderInterface $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @return Collection
     */
    public function today(): Collection
    {
        return $this->reader->readByDate(Carbon::today());
    }

    /**
     * @param int $count
     * @return Collection
     */
    public function last(int $count): Collection
    {
        return $this->page($count, 1);
    }

    /**
     * @param int $count
     * @param int $page
     * @return Collection
     */
    public function page(int $count, int $page): Collection
    {
        $offset = $count * ($page - 1);
        $counter = 0;
        $logs = collect();
        $files = $this->reader->getFiles()->sortKeysDesc();

        $i = 0;

        foreach ($files as $file) {
            foreach ($this->reader->read($file)->sortKeysDesc() as $log) {
                if ($offset > $i++) {
                    continue;
                }

                $logs->push($log);
                $counter++;

                if ($count === $counter) {
                    break;
                }
            }

            if ($count === $counter) {
                break;
            }
        }

        return collect($logs);
    }

    /**
     * @param string $query
     * @return Collection
     */
    public function find(string $query): Collection
    {
        $logs = collect();

        foreach ($this->reader->getFiles() as $file) {
            foreach ($this->reader->read($file) as $log) {
                array_walk_recursive($log, function ($value) use ($query, $logs, $log) {
                    if (is_string($value) && preg_match("/{$query}/i", $value)) {
                        $logs->push($log);
                    }
                });
            }
        }

        return $logs;
    }

    public function count(): int
    {
        $count = 0;
        foreach ($this->reader->getFiles() as $file) {
            foreach ($this->reader->read($file) as $log) {
                $count++;
            }
        }

        return $count;
    }
}
