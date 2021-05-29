<?php

namespace App\Based\Http\Responses;

use Illuminate\Http\JsonResponse;

class ActionResponse extends JsonResponse
{
    public function __construct($success, $data = null, $status = null)
    {
        $array = [
            'success' => $success,
            'data' => $data
        ];

        parent::__construct($array, $status ?? 200, [], 0);
    }

    public static function fromMessage(string $message, bool $success, ?int $status = null): self
    {
        return new static($success, compact('message'), $status);
    }

    public static function fromFailedMessage(string $message, int $status = 409): self
    {
        return self::fromMessage($message, $status);
    }
}
