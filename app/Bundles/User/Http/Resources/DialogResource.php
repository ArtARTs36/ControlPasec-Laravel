<?php

namespace App\Bundles\User\Http\Resources;

use App\Bundles\User\Models\Dialog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * Class DialogResource
 * @mixin Dialog
 * @extends JsonResource<Dialog>
 */
class DialogResource extends JsonResource
{
    protected $messages;

    public function __construct(Dialog $resource, LengthAwarePaginator $messages)
    {
        parent::__construct($resource);

        $this->messages = $messages;
    }

    public function toArray($request): array
    {
        $interUser = $this->getInterUser(Auth::user());

        return [
            'id' => $this->id,
            'inter_user' => [
                'id' => $interUser->id,
                'full_name' => $interUser->getFullName(),
                'avatar_url' => $interUser->getAvatarUrl(),
            ],
            'messages' => DialogMessageResource::collection($this->messages),
            'meta' => [
                'total' => $this->messages->total(),
                'last_page' => $this->messages->lastPage(),
            ],
        ];
    }
}
