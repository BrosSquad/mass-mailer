<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Application extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var \App\Application $application */
        $application = $this->resource['app'];
        return [
            'appName' => $application->app_name,
            'id' => $application->id,
            'createdAt' => $application->created_at,
            'key' => $this->resource['key']
        ];
    }
}
