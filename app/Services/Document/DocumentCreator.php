<?php

namespace App\Services\Document;

use App\Bundles\Document\Models\Document;
use App\Bundles\Document\Models\DocumentType;
use App\Bundles\Supply\Models\ProductTransportWaybill;
use App\Bundles\Supply\Models\ScoreForPayment;
use App\Services\Document\DocumentService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class DocumentCreator
{
    /** @var Document */
    private $document;

    /**
     * DocumentCreator constructor.
     * @param int|null $type
     * @throws \Exception
     */
    public function __construct($type = null)
    {
        $this->document = new Document();
        $this->document->beforeCreate();
        $this->setType($type);
    }

    /**
     * @param int $type
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
     * @param DocumentType|int $type
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
     * @param ScoreForPayment[]|Collection|array|int $scores
     * @return $this
     * @throws \Throwable
     */
    public function addScores($scores): self
    {
        $this->beforeAttached();
        $this->document->scoreForPayments()->attach($this->arrIds($scores));

        return $this;
    }

    /**
     * @param Collection|ProductTransportWaybill[]|array $waybills
     * @return $this
     * @throws \Throwable
     */
    public function addProductTransportWaybills($waybills): self
    {
        $this->beforeAttached();
        $this->document->productTransportWaybills()->attach($this->arrIds($waybills));

        return $this;
    }

    /**
     * @param array|object|int $forms
     * @return $this
     * @throws \Throwable
     */
    public function addOneTForms($forms): self
    {
        $this->beforeAttached();
        $this->document->oneTForms()->attach($this->arrIds($this->arrIds($forms)));

        return $this;
    }

    /**
     * @param array|object|int $forms
     * @return $this
     * @throws \Throwable
     */
    public function addQualityCertificates($forms): self
    {
        $this->beforeAttached();
        $this->document->qualityCertificates()->attach($this->arrIds($this->arrIds($forms)));

        return $this;
    }

    /**
     * @param Document[]|Collection|array $children
     * @return $this
     * @throws \Throwable
     */
    public function addChildren($children): self
    {
        $this->beforeAttached();
        $this->document->children()->attach($this->arrIds($children));

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

    public function build($saveFile = true)
    {
        DocumentBuilder::build($this->document);

        return $this;
    }

    public function get()
    {
        return $this->document;
    }

    /**
     * @param mixed $array
     * @return array<int>
     */
    private function arrIds($array): array
    {
        $array = Arr::wrap($array);

        return array_map(function ($value) {
            return (int) ($value instanceof Model) ? $value->getKey() : $value;
        }, $array);
    }

    /**
     * @throws \Throwable
     */
    private function beforeAttached()
    {
        if ($this->document->id === null) {
            $this->save();
        }
    }
}
