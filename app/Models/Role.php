<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
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
