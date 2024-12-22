<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $fillable = [
        'name',
        'guard_name',
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
            'name',
            'created_at',
        ];
    }
}
