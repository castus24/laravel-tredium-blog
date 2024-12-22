<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property string $main_image
 * @property string $thumbnail_image
 * @property string $published_at
 * @method static Builder|self slug(string $slug)
 * @uses self::scopeSlug()
 */
class Article extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'published_at',
    ];
    protected $withCount = ['likedUsers'];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
            $model->published_at = now();
        });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(300)
            ->height(200)
            ->sharpen(10);
    }

    /**
     * @uses self::scopePublishedAt()
     */
    public static function getAllowedFilters(): array
    {
        return [
            AllowedFilter::scope('published_at'),
        ];
    }

    public static function getAllowedSorts(): array
    {
        return [
            'id',
            'title',
            'slug',
            'published_at',
        ];
    }

    public function scopePublishedAt(Builder $query): Builder
    {
        return $query->orderByDesc('published_at');
    }

    public function scopeSlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    public function likedUsers(): BelongsToMany
    {
        return $this->BelongsToMany(User::class, 'article_user_likes', 'article_id', 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
