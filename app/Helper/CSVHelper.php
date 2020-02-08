<?php

namespace App\Helper;

use App\Helper\CSVHelper\CSVResource;
use App\Helper\CSVHelper\CSVString;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class CSVHelper
{
    /**
     * @param $file
     * @return CSVResource
     */
    public static function loadFile($file)
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
     * @param $data
     * @param $keys
     * @return CSVString
     */
    protected static function createCsvString($data, $keys)
    {
        $map = null;

        foreach ($data as $index => $value) {
            $key = $keys[$index];

            $map[$key] = $value;
        }

        return new CSVString($map);
    }
}
