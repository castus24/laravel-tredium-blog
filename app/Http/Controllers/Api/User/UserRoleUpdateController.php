<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRoleUpdateRequest;
use App\Http\Resources\UserShowResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserRoleUpdateController extends Controller
{
    public function __invoke(UserRoleUpdateRequest $request, User $user): JsonResponse|AnonymousResourceCollection
    {
        if (!auth()->user()->can('user.update')) {
            return response()->json([
                'message' => trans('auth.forbidden')
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        $user->syncRoles($request->input('roles'));

        return response()->json([
            'message' => trans('role.updated'),
            'data' => new UserShowResource($user)
        ]);
    }
}
