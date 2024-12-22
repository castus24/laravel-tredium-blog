<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleAddRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RoleAddController extends Controller
{
    /**
     * @param RoleAddRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(RoleAddRequest $request): JsonResponse|AnonymousResourceCollection
    {
        if (!auth()->user()->can('role.add')) {
            return response()->json([
                'message' => trans('auth.forbidden')
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        $role = Role::findOrCreate($request->validated('name'), $request->validated('guard_name'));

        if ($request->validated('permissions')) {
            $role->givePermissionTo($request->validated('permissions'));
        }

        return response()->json([
            'message' => trans('role.added'),
            'data' => new RoleResource($role)
        ], ResponseAlias::HTTP_CREATED);
    }
}
