<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Login extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'user' => new User($this->resource->user),
            'auth' => [
                'token' => $this->resource->token,
                'refresh' => $this->resource->refreshToken,
                'type' => 'Bearer',
                'expiresIn' => $this->resource->expiresIn,
            ]
        ];
    }
}
