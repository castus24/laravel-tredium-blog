<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserShowResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserListController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(Request $request): JsonResponse|AnonymousResourceCollection
    {
//        if (!auth()->user()->can('user.list')) {
//            return response()->json([
//                'message' => trans('auth.forbidden')
//            ], ResponseAlias::HTTP_FORBIDDEN);
//        }

        return UserShowResource::collection(
            QueryBuilder::for(User::class)
                ->allowedFilters(User::getAllowedFilters())
                ->allowedSorts(User::getAllowedSorts())
                ->paginate($request->input('itemsPerPage', env('ITEMS_PER_PAGE')))
            );
    }
}
