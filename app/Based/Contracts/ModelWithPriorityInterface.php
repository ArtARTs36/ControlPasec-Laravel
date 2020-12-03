<?php

namespace App\Based\Contracts;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface ModelWithPriorityInterface
 * @mixin Builder
 */
interface ModelWithPriorityInterface
{
    /**
     * @return int
     */
    public function getPriority(): int;

    /**
     * @return int
     */
    public function incPriority(): int;

    /**
     * @return int
     */
    public function decPriority(): int;

    /**
     * @param int $priority
     */
    public function setPriority(int $priority): void;
}
