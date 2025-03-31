<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property string $type
 * @property string $value
 * @property bool $is_verified
 */
class UserContact extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'value',
        'is_verified'
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });

        static::updating(function ($model) {
            $model->user_id = auth()->id();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
