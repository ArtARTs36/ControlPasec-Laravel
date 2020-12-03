<?php

namespace App\Support\Log;

use App\Based\Support\FileHelper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

/**
 * Class LogReader
 * @package App\Support\Log
 */
class LogReader implements LogReaderInterface
{
    public const FILE_DATE_FORMAT = 'Y-m-d';
    public const FILE_EXTENSION = 'log';

    /**
     * @return Collection
     */
    public function getFiles(): Collection
    {
        $files = [];
        FileHelper::findFilesWithCallable($this->path(), $files, function (string $path) {
            return File::extension($path) === static::FILE_EXTENSION;
        });

        return collect($files);
    }

    /**
     * @param Carbon $date
     * @return Collection
     */
    public function readByDate(Carbon $date): Collection
    {
        $path = $this->path(
            'laravel-' .
            $date->format(static::FILE_DATE_FORMAT) . '.' .
            static::FILE_EXTENSION
        );

        return $this->read($path);
    }

    /**
     * @param string $path
     * @return Collection
     */
    public function read(string $path): Collection
    {
        return $this->prepare($this->readRaw($path));
    }

    /**
     * @param string $data
     * @return Collection
     */
    public function prepare(string $data): Collection
    {
        return collect(json_decode($data));
    }

    /**
     * @param string $path
     * @return string
     */
    public function readRaw(string $path): string
    {
        $content = file_get_contents($path);
        $this->parse($content);

        return $content;
    }

    /**
     * @param string|null $content
     */
    private function parse(?string &$content)
    {
        $content = '['. $content . ']--end';
        $content = str_replace("\n", ',', $content);
        $content = str_replace(',]--end', ']', $content);
        $content = trim($content);
    }

    /**
     * @param string|null $file
     * @return string
     */
    private function path(?string $file = null): string
    {
        return storage_path('logs/'. $file);
    }
}
