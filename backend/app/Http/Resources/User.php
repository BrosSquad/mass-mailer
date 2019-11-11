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
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->resource->name,
            'surname' => $this->resource->surname,
            'email' => $this->resource->email,
            'role' => $this->resource->getRoles()->first(),
            'avatar' => $this->resource->avatar,
            'backgroundImage' => $this->resource->background_image,
            'bio' => $this->resource->bio
        ];
    }
}
