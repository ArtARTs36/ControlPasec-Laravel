<?php

namespace App\Support\Log;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Class LogRepository
 * @package App\Support\Log
 */
class LogRepository implements LogRepositoryInterface
{
    /** @var LogReaderInterface  */
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
    public function all(): Collection
    {
        $logs = collect();

        foreach ($this->reader->getFiles() as $file) {
            foreach ($this->reader->read($file) as $log) {
                $logs->push($log);
            }
        }

        return $logs;
    }

    /**
     * @return Collection
     */
    public function today(): Collection
    {
        return $this->reader->readByDate(Carbon::today());
    }

    /**
     * @return \stdClass
     */
    public function last(): \stdClass
    {
        return $this->lasts(1)->first();
    }

    /**
     * @param int $count
     * @return Collection
     */
    public function lasts(int $count): Collection
    {
        return $this->page($count, 1);
    }

    /**
     * @return \stdClass
     */
    public function first(): \stdClass
    {
        return $this->firsts(1)->first();
    }

    /**
     * @param int $count
     * @return Collection
     */
    public function firsts(int $count): Collection
    {
        return $this->page($count, 1, static::SORT_ASC);
    }

    /**
     * @param int $count
     * @param int $page
     * @param int $sort
     * @return Collection
     */
    public function page(int $count, int $page, int $sort = self::SORT_DESC): Collection
    {
        $offset = $count * ($page - 1);
        $counter = 0;
        $logs = collect();
        $files = $this->reader->getFiles()->sortKeys(SORT_REGULAR, $sort === static::SORT_DESC ? true : false);

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
     * Полнотекстовый поиск
     *
     * @param string $query
     * @return Collection
     */
    public function findByWord(string $query): Collection
    {
        return $this->findByOneCoincidence(function ($value) use ($query) {
            return is_string($value) && preg_match("/{$query}/i", $value);
        });
    }

    /**
     * Поиск по всем полям из лога
     *
     * @param \Closure $callback
     * @return Collection
     */
    public function find(\Closure $callback): Collection
    {
        $logs = collect();

        $this->mapByAll(function ($value, $log) use ($callback, $logs) {
            if ($callback($value) === true) {
                $logs->push($log);
            }
        });

        return $logs;
    }

    /**
     * Поиск по одному совпадению в логе
     *
     * @param \Closure $callback
     * @return Collection
     */
    public function findByOneCoincidence(\Closure $callback): Collection
    {
        $logs = collect();
        $logsIds = [];

        $this->mapByAll(function ($value, $log) use ($callback, $logs, &$logsIds) {
            $logId = spl_object_id($log);

            if (!isset($logsIds[$logId]) && $callback($value, $log) === true) {
                $logs->push($log);

                $logsIds[$logId] = true;
            }
        });

        return $logs;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $count = 0;
        foreach ($this->reader->getFiles() as $file) {
            $count += $this->reader->read($file)->count();
        }

        return $count;
    }

    /**
     * @param \Closure $callback
     */
    private function mapByAll(\Closure $callback): void
    {
        foreach ($this->reader->getFiles() as $file) {
            foreach ($this->reader->read($file) as $log) {
                array_walk_recursive($log, function ($value) use ($log, $callback) {
                    $callback($value, $log);
                });
            }
        }
    }
}
