<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
        return [
            'appName'    => $this->resource->app_name,
            'id'         => $this->resource->id,
            'created_at' => $this->resource->created_at,
            'created'    => $this->resource->created_at->diffForHumans(),
        ];
    }
}
