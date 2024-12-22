<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionUpdateRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PermissionUpdateController extends Controller
{
    /**
     * @param PermissionUpdateRequest $request
     * @param Permission $permission
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(PermissionUpdateRequest $request, Permission $permission): JsonResponse|AnonymousResourceCollection
    {
        if (!auth()->user()->can('permission.update')) {
            return response()->json([
                'message' => trans('auth.forbidden')
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        $permission->update($request->validated());

        return response()->json([
            'message' => trans('permission.updated'),
            'data' => new PermissionResource($permission)
        ]);
    }
}
