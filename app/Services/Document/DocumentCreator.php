<?php

namespace App\Services\Document;

use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Service\Document\DocumentService;
use Illuminate\Database\Eloquent\Model;

class DocumentCreator
{
    /** @var Document */
    private $document;

    /**
     * DocumentCreator constructor.
     * @param null $type
     * @throws \Exception
     */
    public function __construct($type = null)
    {
        $this->document = new Document();
        $this->document->beforeCreate();
        $this->setType($type);
    }

    /**
     * @param null $type
     * @return DocumentCreator
     * @throws \Exception
     */
    public static function getInstance($type = null)
    {
        return new self($type);
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->document->title = $title;

        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        if ($type instanceof DocumentType) {
            $type = $type->id;
        }

        $this->document->type_id = $type;

        return $this;
    }

    /**
     * @param $scores
     * @return $this
     * @throws \Throwable
     */
    public function addScores($scores): self
    {
        if ($this->document->id === null) {
            $this->save();
        }

        $this->document->scoreForPayments()->attach($this->arrIds($scores));

        return $this;
    }

    /**
     * @return $this
     * @throws \Throwable
     */
    public function refreshTitle(): self
    {
        $this->document->title = $this->document->type->title;
        $this->document->save();
        $this->document->title = DocumentService::parseFileName($this->document);

        return $this;
    }

    /**
     * @return Document
     * @throws \Throwable
     */
    public function save()
    {
        if ($this->document->title === null) {
            $this->refreshTitle();
        }

        $this->document->save();

        return $this->document;
    }

    public function build($saveFile)
    {
        DocumentBuilder::build($this->document, $saveFile);

        return $this;
    }

    public function get()
    {
        return $this->document;
    }

    /**
     * @param $array
     * @return array
     */
    private function arr($array)
    {
        return (is_array($array) ? $array : [$array]);
    }

    private function arrIds($array)
    {
        $array = $this->arr($array);

        return array_map(function ($value) {
            return ($value instanceof Model) ? $value->id : $value;
        }, $array);
    }
}
