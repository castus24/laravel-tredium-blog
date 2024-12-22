<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!isset($validated['name'])) {
            $validated['name'] = $this->extractor($validated['email'])->toString();
        }

        $validated['password'] = Hash::make($validated['password']);

        try {
            $user = User::query()->create($validated);

            /** @var User $user */
            $user->assignRole(RoleEnum::USER);

            return response()->json([
                'message' => trans('auth.register.success'),
                'data' => new UserResource($user)
            ], ResponseAlias::HTTP_CREATED);
        } catch (Throwable $e) {
            Log::error('Registration error: ' . $e->getMessage());

            return response()->json([
                'error' => trans('auth.register.failed'),
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function extractor(string $email): Stringable
    {
        return Str::of(explode('@', $email)[0])
            ->replace(['.', '_', '-'], ' ')
            ->ucfirst()
            ->squish();
    }
}
