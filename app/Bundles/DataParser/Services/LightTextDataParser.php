<?php

namespace App\Services\TextDataParser;

class LightTextDataParser extends AbstractTextDataParser
{
    const SLUG_NULL = '--null--';

    /**
     * @return array
     */
    protected function process(): array
    {
        $data = $this->prepareInputString($this->inputString);

        $items = [];
        foreach ($data as $rowId => $string) {
            $row = explode('|', $string);

            foreach ($row as $columnId => $value) {
                if ($value == self::SLUG_NULL) {
                    $value = null;
                }

                $items[$rowId][$columnId] = $value;
            }
        }

        $preparerPath = 'Parsers/preparer_'. $this->component->preparer . '.php';

        return include($preparerPath);
    }

    /**
     * @param string $string
     * @param string $delimiter
     * @return array
     */
    private function prepareInputString(string $string, string $delimiter = '|'): array
    {
        $data = preg_replace('/\t\t/i', $delimiter. self::SLUG_NULL . $delimiter, $string);
        $data = preg_replace('/\t/i', $delimiter, $data);

        return explode("\n", $data);
    }
}
