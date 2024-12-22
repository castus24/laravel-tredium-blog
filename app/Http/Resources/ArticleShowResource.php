<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property string $main_photo
 * @property string $thumbnail_photo
 * @property string $published_at
 * @method getFirstMediaUrl(string $photos, string $conversion = null)
 */
class ArticleShowResource extends JsonResource
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
            'main' => $this->getFirstMediaUrl('article_photos'),
            'thumbnail' => $this->getFirstMediaUrl('article_photos', 'thumbnail'),
            'published_at' => $this->published_at,
        ];
    }
}
