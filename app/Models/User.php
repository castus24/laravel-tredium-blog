<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 */
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected $with = ['contacts'];

    public static function getAllowedFilters(): array
    {
        return [
            //
        ];
    }

    public static function getAllowedSorts(): array
    {
        return [
            //
        ];
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(UserContact::class);
    }

    public function likedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_user_likes', 'user_id', 'article_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
}
