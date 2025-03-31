<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

abstract class BaseResource extends JsonResource
{
    /**
     * Get the resource type based on the class name.
     *
     * @return string
     */
    protected function getResourceType(): string
    {
        return Str::snake(str_replace('Resource', '', class_basename($this)));
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge([
            'type' => $this->getResourceType(),
        ], $this->additionalData($request));
    }

    /**
     * Method to be implemented in child resources for additional data.
     *
     * @return array<string, mixed>
     */
    abstract protected function additionalData(Request $request): array;
}
