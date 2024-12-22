<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PermissionGroupController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(Request $request): JsonResponse|AnonymousResourceCollection
    {
        if (!auth()->user()->can('permission.list')) {
            return response()->json([
                'message' => trans('auth.forbidden')
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        $permissions = Permission::all()->sortBy('name');

        $role_has_permissions = new Collection([]);

        foreach ($permissions as $permission)
        {
            $root = Str::of($permission->getAttribute('name'))->explode('.')->first();

            if (! $role_has_permissions->has($root)) {
                $role_has_permissions->put($root, collect());
            }

            $role_has_permissions->get($root)->push(
                collect()
                    ->put('id', $permission->getKey())
                    ->put('name', $permission->getAttribute('name'))
                    ->put('label', ucfirst(
                        Str::of($permission->getAttribute('name'))->explode('.')->last()
                    ))
            );
        }

        $groups = new Collection([]);

        foreach ($role_has_permissions as $key => $role_has_permission)
        {
            $groups->push(
                collect()
                    ->put('name', Str::ucfirst($key))
                    ->put('permissions', $role_has_permission)
            );
        }

        return response()->json([
            'data' => $groups
        ]);
    }
}
