<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property string $main_image
 * @property string $thumbnail_image
 * @property string $published_at
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'main_image' => $this->main_image,
            'thumbnail_image' => $this->thumbnail_image,
            'published_at' => $this->published_at,
        ];
    }
}
