<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    public const MAIN_IMAGE = 'https://picsum.photos/800/600';
    public const THUMBNAIL = 'https://picsum.photos/400/300';

    protected $fillable = [
        'title',
        'content',
        'slug',
        'main_image',
        'thumbnail_image',
        'published_at',
    ];
    protected $withCount = ['likedUsers'];

    public function likedUsers(): BelongsToMany
    {
        return $this->BelongsToMany(User::class, 'article_user_likes', 'article_id', 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
