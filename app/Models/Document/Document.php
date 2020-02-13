<?php

namespace App\Models\Document;

use App\Services\Service\OrfoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 */
class Document extends Model
{
    const STATUS_NEW = 0;
    const STATUS_IN_QUEUE = 1;

    const STATUSES = [
        self::STATUS_NEW => 'Документ создан',
        self::STATUS_IN_QUEUE => 'Документ в очереди',
    ];

    /**
     * @return BelongsTo|DocumentType
     */
    public function type()
    {
        return $this->belongsTo(DocumentType::class);
    }

    /**
     * @return mixed|string
     */
    public function getExtensionName()
    {
        return $this->type()->loader()->extension()->name;
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
        return $this->type()->loader()->name;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function beforeCreate()
    {
        $this->uuid = Uuid::getFactory()->uuid4()->toString();

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
}
