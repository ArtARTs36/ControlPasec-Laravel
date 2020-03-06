<?php

namespace DocumentBundle\Exception;

use App\Models\Document\Document;
use Throwable;

/**
 * Class DocumentFailedToSaveException
 *
 * Исключение на случай несохранения документа
 *
 * @package DocumentBundle\Exception
 */
class DocumentFailedToSaveException extends \Exception
{
    public function __construct(Document $document, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf("Не удалось сохранить документ: %s!", $document->title),
            $code,
            $previous
        );
    }
}
