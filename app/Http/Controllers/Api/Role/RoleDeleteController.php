<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RoleDeleteController extends Controller
{
    /**
     * @param Role $role
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(Role $role): JsonResponse|AnonymousResourceCollection
    {
        if (!auth()->user()->can('role.delete')) {
            return response()->json([
                'message' => trans('auth.forbidden')
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        $role->delete();

        return response()->json([
            'message' => trans('role.deleted')
        ]);
    }
}
