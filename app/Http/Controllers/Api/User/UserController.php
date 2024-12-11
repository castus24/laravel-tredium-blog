<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserShowResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __invoke(Request $request): UserShowResource
    {
        return new UserShowResource($request->user());
    }
}
