<?php

namespace App\Helper\CSVHelper;

class CSVString
{
    private $values = null;

    public function __construct($values)
    {
        $this->values = $values;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getValuesWithoutKeys(array $excludeKeys): array
    {
        $array = $this->values;

        foreach ($excludeKeys as $key) {
            unset($array[$key]);
        }

        return $array;
    }

    /**
     * @return mixed|null
     */
    public function getByKey($key)
    {
        return $this->values[$key] ?? null;
    }
}
