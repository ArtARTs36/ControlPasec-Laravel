<?php

namespace App\Bundles\User\Http\Controllers\Auth;

use App\Based\Contracts\Controller;
use App\Bundles\User\Http\Requests\UserRegisterRequest;
use App\Bundles\User\Http\Responses\UserRegisteredResponse;
use App\Bundles\User\Services\RegistrationService;

class RegisterController extends Controller
{
    private $service;

    public function __construct(RegistrationService $service)
    {
        $this->service = $service;
    }

    public function store(UserRegisterRequest $request): UserRegisteredResponse
    {
        try {
            $this->service->registerByRoleId(
                $request->toArray(),
                $request->input(UserRegisterRequest::FIELD_ROLE_ID)
            );

            $answer = [
                true,
                'Вы успешно зарегистрированы на сайте! Необходимо дождаться одобрения администрации портала',
            ];
        } catch (\Throwable $e) {
            $answer = [false, $e->getMessage()];
        }

        return new UserRegisteredResponse(...$answer);
    }
}
