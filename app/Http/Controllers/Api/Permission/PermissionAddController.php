<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionAddRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PermissionAddController extends Controller
{
    /**
     * @param PermissionAddRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(PermissionAddRequest $request): JsonResponse|AnonymousResourceCollection
    {
        if (!auth()->user()->can('permission.add')) {
            return response()->json([
                'message' => trans('auth.forbidden')
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        $permission = Permission::create($request->validated());

        return response()->json([
            'message' => trans('permission.added'),
            'data' => new PermissionResource($permission)
        ], ResponseAlias::HTTP_CREATED);
    }
}
