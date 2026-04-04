<?php

namespace Modules\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Domain\User;

class UserResource extends JsonResource
{
    public function __construct(private User $user) {}

    public function toArray($request): array
    {
        return [
            'id'    => $this->user->id,
            'email' => $this->user->email,
            'role'  => $this->user->role,
        ];
    }
}
