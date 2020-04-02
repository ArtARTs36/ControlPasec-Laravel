<?php

namespace App\Helper;

use App\Helper\CSVHelper\CSVResource;
use App\Helper\CSVHelper\CSVString;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class CSVHelper
{
    /**
     * @param string $file
     * @return CSVResource
     */
    public static function loadFile(string $file)
    {
        if (!file_exists($file)) {
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

    /**
     * @param array $data
     * @param array $keys
     * @return CSVString
     */
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
