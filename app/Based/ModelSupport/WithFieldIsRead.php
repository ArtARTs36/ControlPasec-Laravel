<?php

namespace App\Based\ModelSupport;

trait WithFieldIsRead
{
    public function isRead(): bool
    {
        return $this->is_read === true;
    }

    public function isNotRead(): bool
    {
        return ! $this->isRead();
    }

    public function read(bool $save = true): self
    {
        if ($this->isNotRead()) {
            $this->is_read = true;
        }

        $save && $this->save();

        return $this;
    }
}
