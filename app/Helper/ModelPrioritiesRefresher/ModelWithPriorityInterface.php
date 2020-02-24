<?php

namespace App\Helper\ModelPrioritiesRefresher;

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
