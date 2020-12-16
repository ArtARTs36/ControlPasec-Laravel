<?php

namespace App\Bundles\User\Services;

use App\Bundles\User\Models\Dialog;

final class DialogService
{
    private $messageService;

    public function __construct(DialogMessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function show(Dialog $dialog, int $page = 1): array
    {
        $messages = $dialog
            ->messages()
            ->latest(Dialog::CREATED_AT)
            ->paginate(10, ['*'], 'DialogView', $page);

        $this->messageService->readMessages($messages->items());

        return [$dialog, $messages];
    }
}
