<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAvatarRequest;
use App\Http\Resources\UserShowResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserAvatarUploadController extends Controller
{
    /**
     * @param UserAvatarRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(UserAvatarRequest $request): JsonResponse|AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        try {
            $user
                ->addMediaFromRequest('image')
                ->toMediaCollection('user_images', 'public_images');
        } catch (FileDoesNotExist $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => trans('user.image.not_exist'),
            ], 422);
        } catch (FileIsTooBig $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => trans('user.image.too_big'),
            ], 422);
        }

        return response()->json([
            'message' => trans('user.image.uploaded'),
            'data' => new UserShowResource($user)
        ]);
    }
}
