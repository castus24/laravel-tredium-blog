<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'label'
    ];

    public static function getAllowedFilters(): array
    {
        return [
            //
        ];
    }

    public static function getAllowedSorts(): array
    {
        return [
            'id',
            'label',
        ];
    }
}
