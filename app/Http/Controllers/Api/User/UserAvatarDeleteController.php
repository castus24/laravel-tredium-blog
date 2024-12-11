<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserAvatarDeleteController extends Controller
{
    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(): JsonResponse|AnonymousResourceCollection
    {
        /** @var User $user */
        $user = auth()->user();

        if (!$user->hasMedia('avatars')) {
            return response()->json([
                'message' => trans('user.avatar.not_exist'),
            ], 404);
        }

        $user->clearMediaCollection('avatars');

        return response()->json([
            'message' => trans('user.avatar.deleted')
        ]);
    }
}
