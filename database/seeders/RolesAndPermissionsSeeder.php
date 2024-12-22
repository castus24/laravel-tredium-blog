<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'permission.add',
            'permission.update',
            'permission.delete',
            'permission.list',
            'role.add',
            'role.edit',
            'role.delete',
            'role.list',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => config('auth.defaults.guard')
            ]);
        }

        $adminRole = Role::create([
            'name' => RoleEnum::ADMIN,
            'guard_name' => config('auth.defaults.guard')
        ]);

        Role::create([
            'name' => RoleEnum::USER,
            'guard_name' => config('auth.defaults.guard')
        ]);

        $adminRole->givePermissionTo($permissions);
    }
}
