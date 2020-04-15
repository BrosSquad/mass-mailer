<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppKeyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        if (is_array($this->resource)) {
            /** @var \App\AppKey $applicationKey */
            $applicationKey = $this->resource['application_key'];
        } else {
            /** @var \App\AppKey $applicationKey */
            $applicationKey = $this->resource;
        }

        return [
            'id'          => $applicationKey->id,
            'key'         => $this->when(is_array($this->resource), $this->resource['key']),
            'nonce'       => $applicationKey->nonce,
            'application' => new ApplicationResource($applicationKey->application),
        ];
    }
}
