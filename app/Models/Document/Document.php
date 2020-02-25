<?php

namespace App\Models\Document;

use App\Models\Supply\ProductTransportWaybill;
use App\ScoreForPayment;
use App\Service\Document\DocumentService;
use App\Services\Service\OrfoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
use Ramsey\Uuid\Uuid;

/**
 * Class Document
 *
 * @property int id
 * @property int type_id
 * @property string title
 * @property int status
 * @property DocumentType type
 * @property string uuid
 * @property ScoreForPayment[] scoreForPayments
 * @property int folder
 * @property ProductTransportWaybill[] productTransportWaybills
 * @property string paper_size
 * @property Document[] children
 *
 * @mixin Builder
 */
class Document extends Model
{
    const STATUS_NEW = 0;
    const STATUS_IN_QUEUE = 1;

    const STATUSES = [
        self::STATUS_NEW => 'Документ создан',
        self::STATUS_IN_QUEUE => 'Документ в очереди',
    ];

    private $fullPath = null;

    /**
     * @return BelongsTo|DocumentType
     */
    public function type()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function scoreForPayments(): BelongsToMany
    {
        return $this->belongsToMany(ScoreForPayment::class);
    }

    public function productTransportWaybills(): BelongsToMany
    {
        return $this->belongsToMany(ProductTransportWaybill::class);
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(
            Document::class,
            'document_children',
            'document_id',
            'children_id'
        );
    }

    /**
     * @return ProductTransportWaybill
     */
    public function getProductTransportWaybill()
    {
        return $this->productTransportWaybills[0];
    }

    /**
     * @return mixed|string
     */
    public function getExtensionName()
    {
        return $this->type->loader->extension->name;
    }

    /**
     * Получить название шаблона
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->type->template;
    }

    public function getTemplateFullPath($ext = false)
    {
        return resource_path('views/'. $this->getTemplate()) .
            ($ext ? '.'. $this->getExtensionName() : '');
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return OrfoService::transLit($this->title, true);
    }

    /**
     * @return mixed|string
     */
    public function getLoaderName()
    {
        return $this->type->loader->name;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function beforeCreate()
    {
        $this->status = self::STATUS_NEW;
        $this->uuid = Uuid::getFactory()->uuid4()->toString();
        $this->folder = trim(file_get_contents(base_path(env('DOCUMENT_SAVE_MAP'))));

        return $this;
    }

    /**
     * Переключить на следующий статус
     *
     * @param bool $save
     * @return bool
     */
    public function nextStatus($save = false)
    {
        if ($this->status + 1 <= count(self::STATUSES)) {
            $this->status++;
            if ($save === true) {
                $this->save();
            }

            return true;
        }

        return false;
    }

    public function getScoreForPayment()
    {
        return $this->scoreForPayments[0];
    }

    public function getFolder()
    {
        return $this->folder;
    }

    public function getFullPath()
    {
        if ($this->fullPath === null) {
            $this->fullPath = DocumentService::getDownloadLink($this, true);
        }

        return $this->fullPath;
    }

    public function fileExists()
    {
        return file_exists($this->getFullPath());
    }
}
