<?php

namespace App\Based\Support\CSV;

use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class CSV
{
    public static function ofFile(string $file): CSVResource
    {
        if (! file_exists($file)) {
            throw new FileNotFoundException($file);
        }

        $array = array_map(function ($string) {
            return str_getcsv($string, ';');
        }, file($file));

        $keys = array_shift($array);

        $csvStrings = [];

        foreach ($array as $string) {
            $csvStrings[] = self::createCsvString($string, $keys);
        }

        return new CSVResource($csvStrings, $keys);
    }

    protected static function createCsvString(array $data, array $keys)
    {
        $map = null;

        foreach ($data as $index => $value) {
            $key = $keys[$index];

            $map[$key] = $value;
        }

        return new CSVString($map);
    }
}
