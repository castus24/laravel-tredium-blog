<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RoleListController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(Request $request): JsonResponse|AnonymousResourceCollection
    {
        if (!auth()->user()->can('role.list')) {
            return response()->json([
                'message' => trans('auth.forbidden')
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        return RoleResource::collection(
            QueryBuilder::for(Role::class)
                ->allowedFilters(Role::getAllowedFilters())
                ->allowedSorts(Role::getAllowedSorts())
                ->paginate($request->input('itemsPerPage', env('ITEMS_PER_PAGE')))
        );
    }
}
