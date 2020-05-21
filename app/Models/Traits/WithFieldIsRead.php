<?php

namespace App\Models\Traits;

trait WithFieldIsRead
{
    public function isRead(): bool
    {
        return $this->is_read === true;
    }

    public function isNotRead(): bool
    {
        return $this->is_read === false;
    }

    public function read(): self
    {
        if ($this->isNotRead()) {
            $this->is_read = true;
        }

        $this->save();

        return $this;
    }
}
