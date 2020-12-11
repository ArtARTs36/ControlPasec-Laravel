<?php

namespace App\Bundles\Document\Exceptions;

use Throwable;

class DocumentConvertFailed extends \Exception
{
    public function __construct($filePath, $extension, Throwable $previous = null)
    {
        $message = "Не удалось преобразовать файл: {$filePath} в формат {$extension}";

        parent::__construct($message, 0, $previous);
    }
}
