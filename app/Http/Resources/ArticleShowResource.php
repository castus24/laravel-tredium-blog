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
    private string $type = 'article';

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'main_image' => $this->getFirstMediaUrl('article_images'),
            'thumbnail' => $this->getFirstMediaUrl('article_images', 'thumbnail'),
            'published_at' => $this->published_at,
            'type' => $this->type
        ];
    }
}
