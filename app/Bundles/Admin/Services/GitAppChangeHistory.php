<?php

namespace App\Bundles\Admin\Services;

use App\Bundles\Admin\Contracts\AppChangeHistory;
use App\Bundles\Admin\Entities\AppChange;
use ArtARTs36\GitHandler\Contracts\Logable;
use ArtARTs36\GitHandler\Data\LogCollection;

class GitAppChangeHistory implements AppChangeHistory
{
    protected $back;

    protected $front;

    public function __construct(Logable $back, Logable $front)
    {
        $this->back = $back;
        $this->front = $front;
    }

    public function all(): array
    {
        $changes = [];

        foreach ($this->getAll() as $subject => $logs) {
            foreach ($logs as $log) {
                $changes[] = new AppChange($log->message, $log->author, $log->date, $subject);
            }
        }

        return $this->sortChanges($changes);
    }

    /**
     * @return array<string, LogCollection>
     */
    protected function getAll(): array
    {
        return [
            'back' => $this->back->log() ?? [],
            'front' => $this->front->log() ?? [],
        ];
    }

    /**
     * @param array<AppChange> $changes
     * @return array<AppChange>
     */
    protected function sortChanges(array $changes): array
    {
        usort($changes, function (AppChange $one, AppChange $two): int {
            return $two->date <=> $one->date;
        });

        return $changes;
    }
}
