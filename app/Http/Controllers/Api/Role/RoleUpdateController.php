<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RoleUpdateController extends Controller
{
    /**
     * @param RoleUpdateRequest $request
     * @param Role $role
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(RoleUpdateRequest $request, Role $role): JsonResponse|AnonymousResourceCollection
    {
        if (!auth()->user()->can('role.update')) {
            return response()->json([
                'message' => trans('auth.forbidden')
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        $role->update($request->validated());

        $role->syncPermissions($request->input('permissions'));

        return response()->json([
            'message' => trans('role.updated'),
            'data' => new RoleResource($role)
        ]);
    }
}
