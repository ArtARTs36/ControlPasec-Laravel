<?php

namespace App\Parsers;

class RssParser
{
    /** @var string */
    private $url;

    /**
     * @var \SimpleXMLElement
     */
    private $xml;

    /** @var array */
    private $arrayItems = null;

    public function __construct(string $url)
    {
        $this->url = $url;
        $this->loadXml();
    }

    /**
     * @return array
     */
    public function getArrayItems(): array
    {
        if ($this->arrayItems === null) {
            $this->prepareArrayItems();
        }

        return $this->arrayItems;
    }

    private function prepareArrayItems(): void
    {
        $this->arrayItems = [];
        foreach ($this->xml->children() as $key => $child) {
            foreach ($child->children() as $field => $value) {
                if ($field == 'item') {
                    $this->arrayItems[] = (array) $value;
                }
            }
        }
    }

    private function loadXml(): void
    {
        $this->xml = simplexml_load_file($this->url);
    }
}
