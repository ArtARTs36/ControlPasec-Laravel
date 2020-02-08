<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ActionResponse extends JsonResponse
{
    public function __construct($success, $data = null, $status = null)
    {
        $array = [
            'success' => $success,
            'data' => $data
        ];

        if ($status === null) {
            $status = ($success ? 200 : 204);
        }

        parent::__construct($array, $status, [], 0);
    }
}
