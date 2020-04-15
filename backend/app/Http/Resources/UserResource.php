<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @throws \Exception
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $backgroundImage = $this->resource->background_image ?
            asset('storage/images/backgrounds/'.$this->resource->background_image) : null;
        $avatar = $this->resource->avatar ?
            asset('storage/images/avatars/'.$this->resource->avatar) : null;

        /** @var \App\User $user */
        $user = $this->resource;
        return [
            'name'            => $this->resource->name,
            'surname'         => $this->resource->surname,
            'email'           => $this->resource->email,
            'permissions'     => $user->getAllPermissions()->pluck('display'),
            'role'            => $user->getRoleNames()->first(),
            'avatar'          => $avatar,
            'backgroundImage' => $backgroundImage,
            'bio'             => $this->resource->bio,
            'created_at'      => $this->resource->created_at,
            'created'         => $this->resource->created_at->diffForHumans(),
        ];
    }
}
