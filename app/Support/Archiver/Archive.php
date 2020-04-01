<?php

namespace App\Support\Archiver;

use Illuminate\Support\Collection;

class Archive
{
    /** @var array  */
    private $files;

    /** @var string  */
    private $name;

    /** @var bool */
    private $isCompressSuccess;

    public function __construct(array $files, string $name)
    {
        $this->files = $files;
        $this->name = $name;
        $this->isCompressSuccess = file_exists($name);
    }

    public function getCollection(): Collection
    {
        return Collection::make($this->files);
    }

    public function getFiles(): ?array
    {
        return $this->files;
    }

    public function isCompressSuccess(): bool
    {
        return $this->isCompressSuccess;
    }

    public function delete(): bool
    {
        return $this->isCompressSuccess && unlink($this->name);
    }
}
