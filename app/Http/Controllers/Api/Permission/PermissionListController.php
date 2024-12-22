<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PermissionListController extends Controller
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

        return PermissionResource::collection(
            QueryBuilder::for(Permission::class)
                ->allowedFilters(Permission::getAllowedFilters())
                ->allowedSorts(Permission::getAllowedSorts())
                ->paginate($request->input('itemsPerPage', env('ITEMS_PER_PAGE')))
        );
    }
}
