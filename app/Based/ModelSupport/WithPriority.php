<?php

namespace App\Based\ModelSupport;

/**
 * Trait WithPriority
 * @property int $priority
 */
trait WithPriority
{
    public function getPriority(): int
    {
        return $this->priority;
    }

    public function incPriority(): int
    {
        return ++$this->priority;
    }

    public function decPriority(): int
    {
        return --$this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }
}
