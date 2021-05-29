<?php

namespace App\Bundles\Product\Exceptions;

use Throwable;

class CannotDeleteBasicProduct extends ProductCannotBeDeleted
{
    public function __construct(?string $message = null, $code = 0, Throwable $previous = null)
    {
        $message = $message ?? 'Нельзя удалить продукт являющийся базовым для товаров поставки';

        parent::__construct($message, $code, $previous);
    }
}
