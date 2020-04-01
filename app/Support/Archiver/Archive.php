<?php

namespace App\Support\Archiver;

use Illuminate\Support\Collection;

class Archive
{
    /** @var array  */
    private $files;

    /** @var string  */
    private $path;

    /** @var string */
    private $name;

    /** @var bool */
    private $isCompressSuccess;

    private $timestamp;

    public function __construct(array $files, string $name, string $path, int $timestamp = null)
    {
        $this->files = $files;
        $this->path = $path;
        $this->isCompressSuccess = file_exists($path);
        $this->name = $name;
        $this->timestamp = $timestamp;
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
        return $this->isCompressSuccess && unlink($this->path);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTimeStamp()
    {
        return $this->timestamp;
    }
}
