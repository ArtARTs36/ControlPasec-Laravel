<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class UserRegisteredResponse extends JsonResponse
{
    public function __construct($success = false, $message = null)
    {
        if ($success === true && $message === null) {
            $message = 'Вы успешно зарегистрированы на сайте! Необходимо дождаться одобрения администрации портала';
        }

        $data = [
            'success' => $success,
            'message' => $message
        ];

        parent::__construct($data, $success ? 200 : 409, [], 0);
    }
}
