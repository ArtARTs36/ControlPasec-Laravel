<?php

namespace App\Models\Document;

use App\Models\Supply\OneTForm;
use App\Models\Supply\ProductTransportWaybill;
use App\Models\Supply\QualityCertificate;
use App\Models\Supply\ScoreForPayment;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentBuilder;
use ArtARTs36\RuSpelling\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

/**
 * Class Document
 *
 * @property int $id
 * @property int $type_id
 * @property string $title
 * @property int $status
 * @property DocumentType $type
 * @property string $uuid
 * @property Collection|ScoreForPayment[] $scoreForPayments
 * @property int $folder
 * @property Collection|ProductTransportWaybill[] $productTransportWaybills
 * @property string $paper_size
 * @property Document[] $children
 * @property Collection|OneTForm[] $oneTForms
 * @property Collection|QualityCertificate[] $qualityCertificates
 *
 * @mixin Builder
 */
class Document extends Model
{
    use HasEntities;

    public const STATUS_NEW = 0;
    public const STATUS_IN_QUEUE = 1;
    public const STATUS_GENERATED = 2;

    public const STATUSES = [
        self::STATUS_NEW => 'Документ создан',
        self::STATUS_IN_QUEUE => 'Документ помещен в очередь',
        self::STATUS_GENERATED => 'Документ сгенерирован',
    ];

    private $fullPath = null;

    /**
     * @return BelongsTo|DocumentType
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    /**
     * @return string
     */
    public function getExtensionName(): string
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

    /**
     * Получить полный путь к шаблону
     *
     * @return string
     */
    public function getTemplateFullPath(): string
    {
        return views_path($this->getTemplate()) . '.' . $this->getExtensionName();
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return str_replace(' ', '_', Text::translitToEng($this->title));
    }

    /**
     * @return string
     */
    public function getLoaderName(): string
    {
        return $this->type->loader->name;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function beforeCreate(): self
    {
        $this->status = self::STATUS_NEW;
        $this->uuid = Uuid::getFactory()->uuid4()->toString();
        $this->folder = trim(file_get_contents(base_path(env('DOCUMENT_SAVE_MAP'))));

        return $this;
    }

    public function setStatusGenerated(): self
    {
        return $this->setStatus(static::STATUS_GENERATED);
    }

    public function setStatusInQueue(): self
    {
        return $this->setStatus(static::STATUS_IN_QUEUE);
    }

    public function getStatusText(): string
    {
        return static::STATUSES[$this->status];
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        $this->save();

        return $this;
    }

    public function getFolder()
    {
        return $this->folder;
    }

    public function getFullPath(): string
    {
        if ($this->fullPath === null) {
            $this->fullPath = DocumentService::getDownloadLink($this, true);
        }

        return $this->fullPath;
    }

    public function fileExists(): bool
    {
        return file_exists($this->getFullPath());
    }

    public function deleteFile(): void
    {
        if (($path = $this->getFullPath())) {
            unlink($path);
        }
    }

    public function getDownloadLink(): string
    {
        return request()->getSchemeAndHttpHost() . '/api/documents/' . $this->id . '/download';
    }

    public function build(): string
    {
        (!$this->exists) && $this->save();

        return DocumentBuilder::build($this);
    }
}
