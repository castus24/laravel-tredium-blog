<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PermissionDeleteController extends Controller
{
    /**
     * @param Permission $permission
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(Permission $permission): JsonResponse|AnonymousResourceCollection
    {
        if (!auth()->user()->can('permission.delete')) {
            return response()->json([
                'message' => trans('auth.forbidden')
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        $permission->delete();

        return response()->json([
            'message' => trans('permission.delete')
        ]);
    }
}
