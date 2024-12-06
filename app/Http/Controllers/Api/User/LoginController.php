<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LoginController extends Controller
{
    public function login(LoginRequest $request): LoginResource|JsonResponse
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => "Auth login error"
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        return new LoginResource($request->user());
    }
}