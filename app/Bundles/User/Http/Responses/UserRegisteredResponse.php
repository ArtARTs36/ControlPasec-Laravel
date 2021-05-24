<?php

namespace App\Bundles\User\Http\Responses;

use Illuminate\Http\JsonResponse;

class UserRegisteredResponse extends JsonResponse
{
    public function __construct(bool $success, string $message)
    {
        parent::__construct(
            compact('success', 'message'),
            $success ? 200 : 422,
            [],
            0
        );
    }
}
