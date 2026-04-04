<?php

namespace Modules\User\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Domain\User;

class UserResource extends JsonResource
{
    public function __construct(private User $user) {}

    public function toArray($request): array
    {
        return [
            'id'                => $this->user->id,
            'email'             => $this->user->email,
            'role'              => $this->user->role,
            'email_verified_at' => $this->user->email_verified_at,
            'remember_token'    => $this->user->remember_token
        ];
    }
}
