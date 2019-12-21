<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $backgroundImage = $this->resource->background_image ?
            asset('storage/images/backgrounds/'.$this->resource->background_image) :
            null;
        $avatar = $this->resource->avatar ?
            asset('storage/images/avatars/'.$this->resource->avatar) :
            null;

        return [
            'name'            => $this->resource->name,
            'surname'         => $this->resource->surname,
            'email'           => $this->resource->email,
            'role'            => $this->resource->getRoles()->first(),
            'avatar'          => $avatar,
            'backgroundImage' => $backgroundImage,
            'bio'             => $this->resource->bio,
        ];
    }
}
