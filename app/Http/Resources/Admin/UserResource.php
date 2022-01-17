<?php

namespace App\Http\Resources\Admin;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class UserResource extends JsonResource {

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var User $this */
        return [
            "id" => $this->id,
            "created_at" => $this->created_at,
            "deleted_at" => $this->deleted_at,
            "email" => $this->when((auth()->user()->isAdmin() || auth()->user()->is($this)), fn() => $this->email),
            "role" => $this->when((auth()->user()->isAdmin() || auth()->user()->is($this)), fn() => $this->ownRole()),
            "can" => $this->when((auth()->user()->isAdmin() || auth()->user()->is($this)), fn() => $this->getPermissionArray()),
            "name" => $this->name,
            "slug" => $this->slug,
            "status" => $this->status,
            "links" => [
                "profile" => route('user.edit', $this->slug),
            ],
        ];
    }

}
