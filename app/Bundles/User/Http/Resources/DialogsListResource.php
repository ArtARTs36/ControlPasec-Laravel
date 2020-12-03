<?php

namespace App\Bundles\User\Http\Resources;

use App\Bundles\User\Models\Dialog;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * Class DialogsListResource
 * @mixin Dialog
 * @extends JsonResource<Dialog>
 */
class DialogsListResource extends JsonResource
{
    public function toArray($request): array
    {
        $interUser = $this->getInterUser(Auth::user());

        $message = $this->messages->last()->toArray();

        return [
            'id' => $this->id,
            'last_message' => array_merge(
                $message,
                [
                    'updated_at' => (new \DateTime($message['updated_at']))->format('d.m.y H:i'),
                ]
            ),
            'inter_user' => [
                'id' => $interUser->id,
                'full_name' => $interUser->getFullName(),
                'avatar_url' => $interUser->getAvatarUrl(),
            ],
        ];
    }
}
