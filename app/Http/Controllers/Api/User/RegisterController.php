<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        if (!isset($validated['name'])) {
            $validated['name'] = $this->extractor($validated['email']);
        }

        $validated['password'] = Hash::make($validated['password']);

        $user = User::query()->create($validated);

        return response()->json([
            'message' => 'User created.',
            'data' => new UserResource($user)
        ], ResponseAlias::HTTP_CREATED);
    }

    protected function extractor(string $email): Stringable
    {
        return Str::of(
            ucwords(
                Str::replace(
                    ['.', '_', '-'],
                    [' ', ' ', ' '],
                    explode('@', $email)[0]
                )
            )
        )->squish();
    }
}
